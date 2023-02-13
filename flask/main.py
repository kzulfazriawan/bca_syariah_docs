from sqlalchemy import select
from flask import Flask, request, jsonify
from flask_jwt_extended import JWTManager, create_access_token, get_jwt_identity, jwt_required
from sqlalchemy.exc import NoResultFound

from models import statement, update_statement
from models.user import User

import logging

app = Flask(__name__)
app.debug = True
app.config['SECRET_KEY'] = 'super-secret-service'
jwt_manager = JWTManager(app)

logging.basicConfig(
    filename="web.log", format="%(name)s - %(levelname)s - %(message)s",
    level=logging.DEBUG
)

@app.route("/")
def homepage():
    return "Hello world"


@app.route("/login/", methods=["POST"])
def authentication():
    email, password = (request.json.get("email", None), request.json.get("password", None))
    user = select(User).where(User.email == email).where(User.password == password)
    try:
        stat = statement(user).one()
        access_token = create_access_token(identity=stat.id)
    except AttributeError:
        logging.error(f"{email} Attempt to logged in failed")
        return jsonify(message="Credential Error"), 404
    except NoResultFound:
        logging.error(f"{email} Attempt to logged in failed")
        return jsonify(message="Credential Error"), 404
    else:
        logging.info(f"{email} Attempt to logged in success")
        return jsonify(
            name=stat.name,
            email=stat.email,
            token=access_token
        )


@app.route("/profile/", methods=["GET"])
@jwt_required()
def profile():
    current_user = get_jwt_identity()
    user = select(User).where(User.id == current_user)
    stat = statement(user).one()
    return jsonify(
        id=stat.id,
        name=stat.name,
        email=stat.email,
    ), 200


@app.route("/profile-update/", methods=["PUT"])
@jwt_required()
def profile_update():
    email, name = (request.json.get("email", None), request.json.get("name", None))
    current_user = get_jwt_identity()
    user = select(User).where(User.id == current_user)
    update_statement(user, name=name, email=email)
    return jsonify(message=f"Updated to {name}"), 200


def identity(payload):
    user_id = payload["identity"]
    return select(User).where(User.id == user_id).one()


if __name__ == '__main__':
    app.run()
