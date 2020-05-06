from api import API
from middleware import Middleware
from werkzeug import utils

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


@app.route('/user-page')
def user_page(request, response):
    response.body = app.template('user-page.html')


@app.route('/')
def default(request, response):
    response.text = "<script>location.href='/index';</script>"


@app.route('/login')
class Login:
    def post(self, request, response):
        # temporary
        data = request.POST
        print(data['email'])
        print(data['password'])
        response.location = '/user-page'


@app.route('/register')
class Register:

    def post(self, request, response):
        # temporary
        data = request.POST
        print(data['email'])
        print(data['password'])
        response.location = '/user-page'
        response.text = "<script>location.href='/user-page';</script>"
        # conn = sqlite3.connect('website.db')
        # c = conn.cursor()
        # password = sha256_crypt.encrypt(str(data.get('password')))
        # username = data.get('username')
        # email = data.get('email')
        # result = c.execute("select count(*) from users where email = ?", [email])
        # if len(result.fetchone()[0]) == 0:
        #     c.execute("insert into users(username, password, email) values(?, ?, ?)",
        #               (username, password, email))
        #
        # conn.commit()
        # conn.close()

        pass
