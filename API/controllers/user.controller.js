const db = require("../models");

const Users = db.users;
const Op = db.Sequelize.Op;
exports.getUsers = (req, res) => {

    Users.findAll()
        .then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while retrieving data."
            });
        });

};
exports.addusers = (req, res) => {

    const userdata = {
        Username: req.body.Username,
        email: req.body.email,
        password: req.body.password,
        profilepic: req.body.profilepic,
    };
    Users.create(userdata)
        .then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while creating the Tutorial."
            });
        });

};
exports.update = (req, res) => {
    const id = req.body.id;
    console.log(req.body);
    Users.update(req.body, {
            where: { id: id }
        })
        .then(num => {
            if (num == 1) {
                res.send({
                    message: "Data was updated successfully."
                });
            } else {
                res.send({
                    message: `Cannot update data with id=${id}. Maybe data was not found or req.body is empty!`
                });
            }
        })
        .catch(err => {
            res.status(500).send({
                message: "Error updating data with id=" + id
            });
        });
};

// Find a single Tutorial with an id
exports.login = (req, res) => {
    const username = req.body.Username;
    const password = req.body.Password;

    Users.findOne({ where: { Username: username, Password: password } }).then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while retrieving data."
            });
        });

};
exports.Datasearch = (req, res) => {
    const id = req.body.id;
    const data = Users.findOne({ where: { id: id } }).then(data => {

        res.send(data);
    });
};