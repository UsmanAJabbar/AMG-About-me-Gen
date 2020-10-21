""" data models """
from . import db

class User(db.Model):
    """ User Data model """

    __tablename__ = 'MyDetails'

    userid = db.Column(
        db.Integer,
        primary_key=True
    )

    name = db.Column(
        db.String(64),
        index=True,
        unique=False,
        nullable=False
    )

    status = db.Column(
        db.String(80),
        index=False,
        unique=False,
        nullable=False
    )

    bio = db.Column(
        db.Text,
        index=False,
        unique=False,
        nullable=False
    )

    cvrimg = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=False
    )

    propic = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=False
    )

    def __repr__(self):
        return '<User {}>'.format(self.name)

    def as_dict(self):
        return {c.name: getattr(self, c.name) for c in self.__table__.columns}
