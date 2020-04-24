import sqlite3


conn = sqlite3.connect('website.db')
c = conn.cursor()
result = c.execute("select * from users where email = 'costisuruniuc20@gmail.com'")
print(len(result.fetchall()))
