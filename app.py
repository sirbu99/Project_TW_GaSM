from flask import Flask, render_template, redirect, url_for

from dashboard import dashboardbp
from greport import greportbp
from login import loginbp
from register import registebp
app = Flask(__name__)
app.register_blueprint(registebp)
app.register_blueprint(loginbp)
app.register_blueprint(greportbp)
app.register_blueprint(dashboardbp)
app.secret_key = b'_5#y2L"F4Q8z\n\xec]/'


@app.route('/index')
def index():
    return render_template('index.html')


@app.route('/')
def main():
    return redirect(url_for('index'))


if __name__ == '__main__':
    app.run()
