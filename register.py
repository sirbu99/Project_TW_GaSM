import sqlite3
from flask import Blueprint, request, flash, render_template, redirect, url_for

from passlib.handlers.sha2_crypt import sha256_crypt

registebp = Blueprint('registebp', __name__)


@registebp.route('/register', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        data = request.form
        conn = sqlite3.connect('website.db')
        c = conn.cursor()
        password = sha256_crypt.encrypt(str(data.get('password')))
        username = data.get('username')
        email = data.get('email')
        result = c.execute("select count(*) from users where email = ?", [email])
        if len(result.fetchone()[0]) == 0:
            c.execute("insert into users(username, password, email) values(?, ?, ?)",
                      (username, password, email))

        conn.commit()
        conn.close()

    return redirect(url_for('index'))
