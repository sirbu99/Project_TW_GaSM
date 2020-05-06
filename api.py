import inspect
import os
from webob import Request, Response
from parse import parse
from jinja2 import Environment, FileSystemLoader
from whitenoise import WhiteNoise
from middleware import Middleware


class API:
    def __init__(self, templates_dir='templates', static_dir='static'):
        self.routes = {}
        self.templates_env = Environment(loader=FileSystemLoader(os.path.abspath(templates_dir)))
        self.whitenoise = WhiteNoise(self.wsgi_app, root=static_dir)
        self.middleware = Middleware(self)

    def __call__(self, environ, start_response):
        path_info = environ["PATH_INFO"]

        if path_info.startswith("/static"):
            environ["PATH_INFO"] = path_info[len("/static"):]
            return self.whitenoise(environ, start_response)
        return self.middleware(environ, start_response)

    def add_middleware(self, middleware_cls):
        self.middleware.add(middleware_cls)

    def template(self, template_name, context=None):
        if context is None:
            context = {}

        return self.templates_env.get_template(template_name).render(**context).encode()

    def default_response(self, response):
        response.status_code = 404
        response.text = "404 - Page not found"

    def route(self, path):
        if path in self.routes:
            raise AssertionError('Route already exists!')

        def wrapper(handler):
            self.routes[path] = handler
            return handler

        return wrapper

    def wsgi_app(self, environ, start_response):
        request = Request(environ)

        response = self.handle_request(request)

        return response(environ, start_response)

    def find_handler(self, request_path):
        # if the path is in the existing list of paths return it's handler
        for path, handler in self.routes.items():
            parse_result = parse(path, request_path)
            if parse_result is not None:
                return handler, parse_result.named

    def handle_request(self, request):
        user_agent = request.environ.get("HTTP_USER_AGENT", "No User Agent Found")

        response = Response()
        # check path and get handler
        handler, kwargs = self.find_handler(request_path=request.path)

        if handler is not None:
            # if the handler is a class
            if inspect.isclass(handler):
                # get the corresponding method
                handler = getattr(handler(), request.method.lower(), None)
                # if the handler doesn't allow requested method
                if handler is None:
                    raise AttributeError("Method now allowed", request.method)
                handler(request, response, **kwargs)
            else:
                handler(request, response, **kwargs)
        else:
            self.default_response(response)

        return response
