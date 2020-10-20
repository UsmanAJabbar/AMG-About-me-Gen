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

    print("p0")
    jreq = request.get_json()
    name = jreq['name']
    status = jreq['status']
    bio = jreq['bio']
    response = None
    print(bio)

    if name and status and bio:
        amguser = User(name=name, status=status, bio=bio)
        db.session.add(amguser)
        db.session.commit()
        response = make_response(f"{amguser} successfully created!")

    return response
