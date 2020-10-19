#!/usr/bin/env python3
""" minimal api endpoint """

from flask import Flask, json, request
app = Flask(__name__)


@app.route("/", methods=['GET', 'POST'])
def amg():
    if (request.method == 'POST'):
        with open("file.json", 'w') as f:
            json.dump(request.values, f)
            return json.dumps({'success': True}), 200, \
                {'ContentType': 'application/json'}
    else:
        with open("file.json") as f:
            return json.load(f)

if __name__ == "__main__":
    app.run(port=3000)
