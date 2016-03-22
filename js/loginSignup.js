function _(x) {
    return document.getElementById(x);
}

function ajaxObj(meth, url) {
    var x = new XMLHttpRequest();
    x.open(meth, url, true);
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    return x;
}

function ajaxReturn(x) {
    if (x.readyState == 4 && x.status == 200) {
        return true;
    }
}

function restrict(elem) {
    var tf = $(elem);
    var rx = new RegExp;
    if (elem == "email") {
        rx = /[' "]/gi;
    } else if (elem == "username") {
        rx = /[^a-z0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}

function emptyElement(x) {
    _(x).innerHTML = "";
    _("signupbtn").style.display = "block";
}

//////////////////////////////////////////////////////////

function signup() {
    var firstName = _("firstnameSignup").value;
    var lastName = _("lastnameSignup").value;
    var gender = $('input[name="geslacht"]:checked').attr('id');
    var email = _("emailSignup").value;
    var password = _("passwordSignup").value;
    var school = _("schoolSignup").value;
    var status = _("statusSignup");
    if (firstName == "" || lastName == "" || gender == "" || email == "" || password == "" || school == "") {
        status.innerHTML = "Vul alle velden in";
    } else {
        _("signupbtn").style.display = "none";
        status.innerHTML = 'even geduld';
        var ajax = ajaxObj("POST", "http://vas-y.comlu.com/signup.php");

        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                console.log(ajax.responseText);

                var trimmedResponse = ajax.responseText.replace(/^\s*/, '').replace(/\s*$/, '').toLowerCase();
                if (trimmedResponse != 'signup_success') {
                    _("signupbtn").style.display = "block";
                    status.innerHTML = ajax.responseText;
                } else {
                    status.innerHTML = "Signup succesvol!"
                    _("signupbtn").style.display = "block";
                }

            }
        }
    }
    ajax.send("firstName=" + firstName + "&lastName=" + lastName + "&gender=" + gender + "&email=" + email + "&password=" + password + "&school=" + school)
}

function tryLogin() {
    var e = _("email").value;
    var p = _("password").value;
    if (e == "" || p == "") {
        _("statusLogin").innerHTML = "Vul alle velden in...";
    } else {
        _("loginbtn").style.display = "none";
        _("statusLogin").innerHTML = 'please wait ...';
        var ajax = ajaxObj("POST", "http://vas-y.comlu.com/login.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                if (ajax.responseText == "login_failed") {
                    console.log("failed to login");

                    _("statusLogin").innerHTML = "Login unsuccessful, please try again.";
                    _("loginbtn").style.display = "block";
                } else {
                    _("loginbtn").style.display = "block";
                    //_("statusLogin").innerHTML = "Logged in succesfully";
                    window.location = "http://vas-y.comlu.com/user.php?email="+ajax.responseText;
                }
            }
        }
        ajax.send("e=" + e + "&p=" + p);
    }
}

function tryLogout() {

    $.ajax({
        url: "http://vas-y.comlu.com/logout.php?logout=true",
        type: "get",
        success: function (data) {
            if (data == "worked")
                location.reload();
        }
    })
}