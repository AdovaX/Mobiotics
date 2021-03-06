const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const db = require("../models");
const Gainers = db.gainers;
const Losers = db.losers;
const CData = db.CData;
const Op = db.Sequelize.Op;

exports.findAll = (req, res) => {
    const title = req.query.title;
    var condition = title ? {
        title: {
            [Op.like]: `%${title}%`
        }
    } : null;

    CData.findAll({ where: condition })
        .then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while retrieving data."
            });
        });

};
exports.findOne = (req, res) => {
    const company = req.body.company;
    console.log(req.body.company);
    CData.findAll({
        where: {
            company: {
                [Op.like]: '%' + company + '%'
            }
        }
    }).then(function(data) {
        res.send(data);
    });
};
exports.gainers = (req, res) => {
    Gainers.findAll()
        .then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while retrieving data."
            });
        });
};
exports.losers = (req, res) => {
    Losers.findAll()
        .then(data => {
            res.send(data);
        })
        .catch(err => {
            res.status(500).send({
                message: err.message || "Some error occurred while retrieving data."
            });
        });
};
exports.Datasearch = (req, res) => {
    const code = req.body.Symbol;
    const data = CData.findOne({ where: { Symbol: code } }).then(data => {

        res.send(data);
    });
};