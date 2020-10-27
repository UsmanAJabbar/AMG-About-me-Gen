from flask import request, make_response, jsonify
from flask import current_app as app
from models import db, Profile


@app.route('/', methods=['GET'])
def get_profile():
    """ get latest profile """

    count = Profile.query.count()
    profile = Profile.query.get(count)
    return Profile.as_dict(profile) 

@app.route('/', methods=['POST'])
def add_profile():
    """ add profile """

    jreq = request.get_json()
    name = jreq['name']
    status = jreq['status']
    bio = jreq['description']
    phone = jreq['phone']
    email = jreq['email']
    cvrimg = jreq['cvrimg']
    propic = jreq['propic']
    github = jreq['github']
    twitter = jreq['twitter']
    facebook = jreq['facebook']
    instagram = jreq['instagram']
    medium = jreq['medium']
    response = None

    if name and status and bio and cvrimg and propic:
        newprofile = Profile(name=name, status=status, bio=bio, cvrimg=cvrimg, propic=propic, email=email, phone=phone, github=github, twitter=twitter, facebook=facebook, instagram=instagram, medium=medium)
        db.session.add(newprofile)
        db.session.commit()
        response = make_response(f"{newprofile} successfully created!")

    return response
