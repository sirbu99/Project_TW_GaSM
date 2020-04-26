from flask import Blueprint

dashboardbp = Blueprint('dashboardbp', __name__)

dashboardbp.route('/dashboard', methods=['GET', 'POST'])


def dashboard():
    pass
