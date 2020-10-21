from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

db = SQLAlchemy() 


def create_app():
    """ core app """
    app = Flask(__name__, instance_relative_config=False)
    app.config.from_object('config.Config')

    db.init_app(app)

    cors = CORS(app, resources={r"/": {"origins": "http://localhost"}})

    with app.app_context():
        from . import routes
        db.create_all()

    return app
