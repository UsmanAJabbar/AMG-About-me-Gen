""" data models """
from sqlalchemy import ForeignKey, Column, Integer, String
from sqlalchemy.orm import relationship
from . import db

class Profile(db.Model):
    """ User Data model """

    __tablename__ = 'profiles'

    id = db.Column(
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

    phone = db.Column(
        db.String(12),
        index=False,
        unique=False,
        nullable=True
    )

    email = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
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

    twitter = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    github = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    medium = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    instagram = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    linkedin = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    facebook = db.Column(
        db.String(48),
        index=False,
        unique=False,
        nullable=True
    )

    def __repr__(self):
        return '<User {}>'.format(self.name)

    def as_dict(self):
        return {c.name: getattr(self, c.name) for c in self.__table__.columns}
