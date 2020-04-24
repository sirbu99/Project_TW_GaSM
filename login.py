import sqlite3

from flask import Blueprint, request, session, url_for, redirect
from passlib.handlers.sha2_crypt import sha256_crypt

loginbp = Blueprint('loginbp', __name__)


@loginbp.route('/login', methods=['POST'])
def login():
    if request.method == 'POST':
        conn = sqlite3.connect('website.db')
        c = conn.cursor()
        data = request.form
        result = c.execute('select * from users where username = ?', [data.get('username')])
        if sha256_crypt.verify(data.get('password'), result.fetchone()[2]):
            session['logged_in'] = True
            session['username'] = data.get('username')
    return redirect(url_for('index'))
