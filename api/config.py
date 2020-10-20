from os import environ, path

basedir = path.abspath(path.dirname(__file__))

class Config:
    """set up some vars"""

    '''SECRET_KEY = environ.get('SECRET_KEY')'''
    '''FLASK_APP = environ.get('FLASK_APP')'''
    '''FLASK_ENV = environ.get('FLASK_ENV')'''

    SQLALCHEMY_DATABASE_URI = 'sqlite:///amg.db' 
    SQLALCHEMY_ECHO = False
    SQLALCHEMY_TRACK_MODIFICATIONS=False

    CORS_HEADERS = 'Content-Type'
