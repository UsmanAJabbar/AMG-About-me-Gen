from flask import request, make_response, jsonify
from flask import current_app as app
from .models import db, User


@app.route('/', methods=['GET'])
def get_profile():
    """ get latest profile """

    profile = User.query.first()
    return User.as_dict(profile) 

@app.route('/', methods=['POST'])
def add_profile():
    """ add profile """

    jreq = request.get_json()
    name = jreq['name']
    status = jreq['status']
    bio = jreq['bio']
    cvrimg = jreq['cvrimg']
    propic = jreq['propic']
    response = None

    if name and status and bio and cvrimg and propic:
        amguser = User(name=name, status=status, bio=bio, cvrimg=cvrimg, propic=propic)
        db.session.add(amguser)
        db.session.commit()
        response = make_response(f"{amguser} successfully created!")

    return response
