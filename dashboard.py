from flask import Blueprint, render_template

dashboardbp = Blueprint('dashboardbp', __name__)

@dashboardbp.route('/info', methods=['GET', 'POST'])


def dashboard():
    return render_template('index.html')
    pass
