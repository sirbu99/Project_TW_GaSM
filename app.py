from api import API
from middleware import Middleware

app = API()


class DefaultMiddleware(Middleware):
    def process_request(self, req):
        print("Processing request", req.url)

    def process_response(self, req, res):
        print("Processing response", req.url)


app.add_middleware(DefaultMiddleware)


@app.route('/index')
def index(request, response):
    response.body = app.template('index.html')


