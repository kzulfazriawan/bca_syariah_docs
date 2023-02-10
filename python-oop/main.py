class App:
    def __init__(self, **kwargs):
        """
        Ini adalah constructor method dari class App
        """
        self.xyz  = 123
        self.data = kwargs
        
    def getXyz(self):
        return self.xyz, self.data, "Jumatan"
        
    def setXyz(self, value):
        self.xyz = value


class SubApp(App):
    def __init__(self, **kwargs):
        """
        Ini adalah contstructor method untuk mengimplementasikan
        attribute dan method dari parent class yang di-inheritkan (App)
        """
        super().__init__(**kwargs)

    @property
    def showDataWithXyz(self):
        """
        Ini adalah method yang dimanipulasi menjadi attribute
        dengan decorator @property
        """
        self.data["xyz"] = self.xyz
        return self.data

    def showAll(self, m1, m2):
        print(m1, m2)


if __name__ == "__main__":
    app = SubApp(name="franky", age=33)
#    for i in app.getXyz():
#        print(i)
    app.setXyz(456)
#    print(app.getXyz())
#    print(app.showDataWithXyz)
#    print(app.getXyz)
    app.showAll(app.showDataWithXyz, app.getXyz)
