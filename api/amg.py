from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

db = SQLAlchemy() 


app = Flask(__name__, instance_relative_config=False)
app.config.from_object('config.Config')

db.init_app(app)

cors = CORS(app, resources={r"/": {"origins": "*"}})

with app.app_context():
    import routes
    db.create_all()
