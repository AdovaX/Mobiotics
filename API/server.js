const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const user = require("./controllers/user.controller.js");
const db = require("./models");

const app = express();
app.use(cors());
const PORT = process.env.PORT || 4247;
//require("./routes/ turorial.routes")(app);
db.sequelize.sync();
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.get("/", user.getUsers);
app.post("/add", user.addusers);
app.post("/edit", user.update);
app.post("/login", user.login);
app.post("/search", user.Datasearch);


app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}.`);
});