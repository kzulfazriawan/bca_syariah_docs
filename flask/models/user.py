from sqlalchemy import String
from sqlalchemy.orm import MappedColumn, Mapped, mapped_column
from sqlalchemy.orm import DeclarativeBase


class Base(DeclarativeBase):
    pass


class User(Base):
    __tablename__ = "user"

    id: Mapped[int] = mapped_column(primary_key=True)
    name: Mapped[str] = mapped_column(String(30))
    email: Mapped[str] = mapped_column(String(20))
    password: Mapped[str] = mapped_column(String(20))

    def __repr__(self):
        return {
            "id": self.id,
            "name": self.name,
            "email": self.email
        }
