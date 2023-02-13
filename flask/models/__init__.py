from sqlalchemy import create_engine
from sqlalchemy.orm import Session

engine = create_engine("mysql+mysqldb://root:example@localhost/project_flask")


def statement(query):
    session = Session(engine)
    stat = session.scalars(query)
    session.commit()
    return stat


def update_statement(query, **kwargs):
    session = Session(engine)
    stat = session.scalars(query).one()
    for k, v in kwargs.items():
        setattr(stat, k, v)
    session.commit()
