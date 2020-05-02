import sqlite3
from datetime import datetime

from flask import Blueprint, request, redirect, url_for, json

greportbp = Blueprint('greportbp', __name__)


@greportbp.route('/getdata', methods=['POST', 'GET'])
def getdata():
    try:
        conn = sqlite3.connect('website.db')
        c = conn.cursor()
        data = request.form
        result = c.execute("select * from recycle_locations join garbage g on recycle_locations.id = g.location_id")
        output = []
        for info in result.fetchall():
            output.append({'name': info[1], 'address': info[2], 'date': info[10], 'plastic': info[5], 'metal': info[6],
                           'paper': info[7], 'waste': info[8], 'glass': info[9]})
        return json.jsonify(output)
    except Exception as e:
        print(e)
        return redirect(url_for('index')), 500


@greportbp.route('/report', methods=['POST'])
def report():
    try:
        conn = sqlite3.connect('website.db')
        c = conn.cursor()
        data = request.form
        result = c.execute('select * from recycle_locations where name = ?', [data.get('place')])
        value = result.fetchone()[0]
        if value != 0:
            now = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
            c.execute(
                'insert into garbage(location_id, plastic, paper, metal, waste, glass, date) values (?, ?, ?, ?, ?, '
                '?, ?)',
                (value, data.get('plastic'), data.get('paper'), data.get('metal'), data.get('mixedGarbage'),
                 data.get('glass'), now))
            conn.commit()
            conn.close()
        return redirect('/index')
    except Exception as e:
        print(e)
        return redirect(url_for('index'))


@greportbp.route('/locationdata', methods=['POST', 'GET'])
def getlocations():
    try:
        conn = sqlite3.connect('website.db')
        c = conn.cursor()
        result = c.execute("select name from recycle_locations")
        output = []
        for info in result.fetchall():
            output.append({'name': info[0]})
        return json.jsonify(output)
    except Exception as e:
        print(e)
        return redirect(url_for('index')), 500
