module.exports = (sequelize, Sequelize) => {
    const Users = sequelize.define("Users", {
        Username: {
            type: Sequelize.STRING
        },
        email: {
            type: Sequelize.STRING,
            unique: true
        },
        password: {
            type: Sequelize.STRING
        },
        profilepic: {
            type: Sequelize.STRING
        }
    });

    return Users;
};