const express = require('express')
const app = express()
const port = 3000
const mysql = require('mysql2')
const bodyParser = require("body-parser")
const bcrypt = require("bcrypt")
const fetch = require("node-fetch")
const cookieParser = require("cookie-parser")
const crypto = require("crypto")
const { text } = require('body-parser')
const axios = require("axios")

app.set('view-engine', 'ejs')
app.use(cookieParser())
var urlencodedParser = bodyParser.urlencoded({ extended: false })

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "buffed"
});

con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
});




app.get('/', (req, res) => {
    if (req.cookies.user) {
        res.render('index.ejs')
    } else {
        res.redirect('/login')
    }
})

app.get('/login', (req, res) => {
    res.render('login.ejs')

})
app.get("/register", (req, res) => {
    res.render("register.ejs")
})
app.get('/plany', (req, res) => {
    var cookie
    if (req.cookies.user) {
        cookie = req.cookies.user.toString()
        con.query(`SELECT id FROM users WHERE login = '${cookie}';`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                var id = result[0].id
                con.query(`SELECT id FROM plany WHERE id_usera = ${id};`, function (err, result, fields) {
                    if (result && Object.keys(result).length > 0) {
                        res.redirect('/planyGit')
                    } else {
                        res.render('plany.ejs')
                    }
                })
            } else {
                res.redirect('/login')
            }
        })
    } else {
        res.redirect('/login')
    }
})
app.get('/planyGit', (req, res) => {
    if (req.cookies.user) {
        var cookie = req.cookies.user.toString()
        con.query(`SELECT id FROM users WHERE login = '${cookie}';`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                var idUser = result[0].id
                con.query(`SELECT id_usera, dzien, cwiczenie, powtorzenia, waga FROM plany WHERE id_usera = ${idUser} ORDER BY dzien;`, function (err, result, fields) {
                    if (Object.keys(result).length > 0) {
                        var obj = { Monday: [], Tuesday: [], Wednesday: [], Thursday: [], Friday: [], Saturday: [], Sunday: [] }
                        for (var i = 0; i < Object.keys(result).length; i++) {
                            switch (result[i].dzien) {
                                case "Monday":
                                    obj.Monday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Tuesday":
                                    obj.Tuesday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Wednesday":
                                    obj.Wednesday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Thursday":
                                    obj.Thursday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Friday":
                                    obj.Friday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Saturday":
                                    obj.Saturday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                                case "Sunday":
                                    obj.Sunday.push({ exercise: result[i].cwiczenie, reps: result[i].powtorzenia, weight: result[i].waga })
                                    break;
                            }
                        }

                        var wyswietl = '<head>           <title>Traning Plan</title><meta charset="utf-8" /><meta name="viewport" content="initial-scale=1.0, width=device-width" /><link rel="stylesheet" href="style.css"></head><body><div class="header-container"><a href="../"><img class="buffed-icon" src="/icons/buffed_icon.svg"></a><img class="page-icon" src="/icons/timetable_icon_dark.svg"></div><div class="training-container"><div class="text-container"><div class="training-plan">';
                        wyswietl += "<p>Monday</p>"
                        for (var i = 0; i < obj.Monday.length; i++) {
                            wyswietl += obj.Monday[i].exercise + " " + obj.Monday[i].reps + " " + obj.Monday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Tuesday</p>"
                        for (var i = 0; i < obj.Tuesday.length; i++) {
                            wyswietl += obj.Tuesday[i].exercise + " " + obj.Tuesday[i].reps + " " + obj.Tuesday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Wednesday</p>"
                        for (var i = 0; i < obj.Wednesday.length; i++) {
                            wyswietl += obj.Wednesday[i].exercise + " " + obj.Wednesday[i].reps + " " + obj.Wednesday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Thursday</p>"
                        for (var i = 0; i < obj.Thursday.length; i++) {
                            wyswietl += obj.Thursday[i].exercise + " " + obj.Thursday[i].reps + " " + obj.Thursday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Friday</p>"
                        for (var i = 0; i < obj.Friday.length; i++) {
                            wyswietl += obj.Friday[i].exercise + " " + obj.Friday[i].reps + " " + obj.Friday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Saturday</p>"
                        for (var i = 0; i < obj.Saturday.length; i++) {
                            wyswietl += obj.Saturday[i].exercise + " " + obj.Saturday[i].reps + " " + obj.Saturday[i].weight + "<br>"
                        }
                        wyswietl += "<p>Sunday</p>"
                        for (var i = 0; i < obj.Sunday.length; i++) {
                            wyswietl += obj.Sunday[i].exercise + " " + obj.Sunday[i].reps + " " + obj.Sunday[i].weight + "<br>"
                        }
                        wyswietl += `<form action='' method = 'post'>
                        <button type = 'submit' class="create-button">New plan</button> 
                        </form></body>`
                        res.send(wyswietl)
                    }
                })
            }
        })
    }
})
app.post('/planyGit', (req, res) => {
    if (req.cookies.user) {
        var cookie = req.cookies.user.toString()
        con.query(`SELECT id FROM users WHERE login = '${cookie}';`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                var idUser = result[0].id
                con.query(`DELETE FROM plany WHERE id_usera = ${idUser};`)
                res.redirect('/plany')
            }
        })
    }
})

app.post('/plany', urlencodedParser, (req, res) => {
    if (req.cookies.user) {
        var cookie = req.cookies.user.toString()
        con.query(`SELECT id FROM users WHERE login = '${cookie}';`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                var id = result[0].id
                console.log('a')
                var textTablica = req.body.cwiczenia
                var tablica = JSON.parse(textTablica)
                console.log(tablica.length)
                for (var i = 0; i < tablica.length; i++) {
                    var dzien = tablica[i].day
                    var cwiczenie = tablica[i].exercise
                    var powtorzenia = tablica[i].reps
                    var waga = tablica[i].weight
                    con.query(`INSERT INTO plany (id_usera, dzien, cwiczenie, powtorzenia, waga) VALUES ('${id}', '${dzien}', '${cwiczenie}', '${powtorzenia}', '${waga}');`, function (err, result, fields) {
                        if (err) throw err;
                        console.log("dodano");

                    })
                }
                res.redirect('/planyGit')
            }
        })

    } else {
        res.redirect('/login')
    }
})

app.get("/dieta", (req, res) => {
    res.render("dieta.ejs")
})


app.post('/dieta', urlencodedParser, (req, res) => {
    var produkt = req.body.produkt
    axios.get(`https://api.nal.usda.gov/fdc/v1/foods/search?query='${produkt}'&pageSize=2&api_key=H2QQzAxDL6ucyhwobLT4q3W9hcH98w4hIPD9ZZQD`)
        .then(response => {
            var wapn = response.data.foods[0].foodNutrients[0].value
            var zelazo = response.data.foods[0].foodNutrients[1].value
            var sol = response.data.foods[0].foodNutrients[2].value
            var a = response.data.foods[0].foodNutrients[3].value
            var c = response.data.foods[0].foodNutrients[4].value
            var cholesterol = response.data.foods[0].foodNutrients[5].value
            var kt = response.data.foods[0].foodNutrients[6].value
            var proteiny = response.data.foods[0].foodNutrients[7].value
            var weglowodany = response.data.foods[0].foodNutrients[8].value
            var kcal = response.data.foods[0].foodNutrients[9].value
            var cukry = response.data.foods[0].foodNutrients[10].value
            var blonnik = response.data.foods[0].foodNutrients[11].value
            var potas = response.data.foods[0].foodNutrients[12].value
            var kt2 = response.data.foods[0].foodNutrients[13].value
            var lip = response.data.foods[0].foodNutrients[14].value
            con.query(`INSERT INTO nutrients VALUES ('${produkt}','${wapn}','${zelazo}','${sol}','${a}','${c}','${cholesterol}','${kt}','${proteiny}'
        ,'${weglowodany}','${kcal}','${cukry}','${blonnik}','${potas}','${kt2}','${lip}')`, function (err, result) {
                if (err) throw err
            })
            con.query(`SELECT * FROM nutrients WHERE produkt = '${produkt}';`, function (err, result, fields) {
                res.send(`
            <head>          <title>Traning Plan</title><meta charset="utf-8" /><meta name="viewport" content="initial-scale=1.0, width=device-width" /><link rel="stylesheet" href="style.css"></head><body><div class="header-container"><a href="../"><img class="buffed-icon" src="/icons/buffed_icon.svg"></a><img class="page-icon" src="/icons/diet_icon_dark.svg"></div><div class="training-container"><div class="text-container"><div class="training-plan">
            <h2>Produkt: ${result[0].produkt}</h2>
            <p>Wapń: ${result[0].wapn}</p>
            <p>Żelazo: ${result[0].zelazo}</p>
            <p>Sól: ${result[0].sol}</p>
            <p>Witamina A: ${result[0].a}</p>
            <p>Witamina C: ${result[0].c}</p>
            <p>Cholesterol: ${result[0].cholesterol}</p>
            <p>Kwasy tłuszczowe: ${result[0].kt}</p>
            <p>Proteiny: ${result[0].proteiny}</p>
            <p>Węglowodany: ${result[0].weglowodany}</p>
            <p>Kcal: ${result[0].kcal}</p>
            <p>Cukry: ${result[0].cukry}</p>
            <p>Błonnik: ${result[0].blonnik}</p>
            <p>Potas: ${result[0].potas}</p>
            <p>Kwasy tłuszczowe (trans): ${result[0].kt2}</p>
            <p>Lipidy: ${result[0].lip}</p>`)

            })

        })

})








app.post("/login", urlencodedParser, (req, res) => {
    var login = req.body.login
    login = login.slice(0, -1)
    var pass = req.body.pass
    con.connect(function (err) {
        con.query(`SELECT * FROM users WHERE haslo ="${pass}" AND login="${login}"`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                console.log(result)
                res.cookie("user", login)
                res.redirect("/")
            }
            else {
                res.render("error-login.ejs",
                    {
                        'login': login,
                        'pass': pass
                    })
            }
        })
    }


    )
})

app.get('/chat', (req, res) => {
    res.render('chat.ejs')
})

app.post("/login", urlencodedParser, (req, res) => {
    var login = req.body.login
    login = login.slice(0, -1)
    var pass = req.body.pass
    con.connect(function (err) {
        con.query(`SELECT * FROM users WHERE haslo ="${pass}" AND login="${login}"`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                console.log(result)
                res.cookie("user", login)
                res.redirect("/")
            }
            else {
                res.render("error-login.ejs",
                    {
                        'login': login,
                        'pass': pass
                    })
            }
        })
    }


    )
})


app.post("/register", urlencodedParser, (req, res) => {
    var name = req.body.name
    var surname = req.body.surname
    var login = req.body.login
    login = login.slice(0, -1)
    var pass = req.body.pass
    var pass1 = req.body.pass1
    con.query(`SELECT id FROM users WHERE login = '${login}';`, function (err, result, fields) {
        if (Object.keys(result).length > 0) {
            res.render("reserved.ejs",
                {
                    'name': name,
                    'surname': surname,
                    'login': login,
                    'pass': pass,
                    'pass1': pass1
                })
        } else {
            console.log(Object.keys(result).length)
            if (pass == pass1) {
                con.query(`INSERT INTO users(imie, nazwisko, login, haslo) VALUES ('${name}','${surname}','${login}','${pass}')`, function (err, result) {
                    if (err) throw err
                    res.render("success-signup.ejs")
                })
            }
            else {
                res.render("error-signup.ejs",
                    {
                        'name': name,
                        'surname': surname,
                        'login': login,
                        'pass': pass,
                        'pass1': pass1
                    })
            }
        }
    })

}
)

app.get('/trening', (req, res) => {

    if (req.cookies.user) {
        var cookie = req.cookies.user.toString()
        con.query(`SELECT id FROM users WHERE login = '${cookie}';`, function (err, result, fields) {
            if (Object.keys(result).length > 0) {
                console.log('a')
                var idUser = result[0].id
                var d = new Date().getDay()
                var day
                switch (d) {
                    case 0:
                        day = "Sunday"
                        break;
                    case 1:
                        day = "Monday"
                        break;
                    case 2:
                        day = "Tuesday"
                        break;
                    case 3:
                        day = "Wednesday"
                        break;
                    case 4:
                        day = "Thursday"
                        break;
                    case 5:
                        day = "Friday"
                        break;
                    case 6:
                        day = "Saturday"
                        break;
                }
                con.query(`SELECT * FROM plany WHERE dzien = '${day}' AND id_usera = ${idUser};`, function (err, result, fields) {
                    if (Object.keys(result).length > 0) {
                        var wyswietl = `<!DOCTYPE html><head><title>Traning Plan</title><meta charset="utf-8" /><meta name="viewport" content="initial-scale=1.0, width=device-width" /><link rel="stylesheet" href="style.css"></head><body><a href="../"><img class="buffed-icon-yellow" src="/icons/buffed_icon_yellow.svg"></a><div class="training-container"><div class="text-container"><div class="training-plan"><p><b>${day}</b></p>`;
                        wyswietl += "<b>Exercise</b>   <b>Reps</b>    <b>Weight <br>"
                        for (var i = 0; i < result.length; i++) {
                            wyswietl += "<p>" + result[i].cwiczenie + "  " + result[i].powtorzenia + "  " + result[i].waga + "<input class='checkbox' type='checkbox'></p>"
                        }
                        res.send(wyswietl)
                    } else {
                        res.redirect("/plany");
                    }
                })
            }
        })
    }
})



app.get('/bmi', (req, res) => {
    res.render('bmi.ejs')
})

app.get('/logout', (req, res) => {
    res.clearCookie("user")
    res.redirect('/login')

})




app.listen(port, () => {
    console.log(`Example app listening on port ${port}`)
})



app.use(express.static(__dirname + '/public'));