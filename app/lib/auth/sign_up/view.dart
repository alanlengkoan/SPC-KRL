import 'package:egg_detection/auth/sign_in/view.dart';
import 'package:egg_detection/networks/api.dart';
import 'package:flutter/material.dart';
import 'dart:convert';

import 'package:rflutter_alert/rflutter_alert.dart';

class SignUp extends StatefulWidget {
  @override
  State<SignUp> createState() => _SignUpState();
}

class _SignUpState extends State<SignUp> {
  final _formKey = GlobalKey<FormState>();
  bool _klik = false;

  TextEditingController controllerNama = TextEditingController();
  TextEditingController controllerEmail = TextEditingController();
  TextEditingController controllerUsername = TextEditingController();
  TextEditingController controllerPassword = TextEditingController();

  String? _validasiNama(String? value) {
    if (value == null || value.isEmpty) {
      return 'Nama Pelapor, Wajib diisi!';
    }
    return null;
  }

  String? _validasiEmail(String? value) {
    if (value == null || value.isEmpty) {
      return 'Email, Wajib diisi!';
    }
    return null;
  }

  String? _validasiUsername(String? value) {
    if (value == null || value.isEmpty) {
      return 'Username, Wajib diisi!';
    }
    return null;
  }

  String? _validasiPassword(String? value) {
    if (value == null || value.isEmpty) {
      return 'Password, Wajib diisi!';
    }
    return null;
  }

  _addData() async {
    var data = {
      "nama": controllerNama.text,
      "email": controllerEmail.text,
      "username": controllerUsername.text,
      "password": controllerPassword.text,
    };

    var response = await Network().auth(data, '/register');
    var body = json.decode(response.body);
    var type;
    print(body);
    if (body['status']) {
      type = AlertType.success;
    } else {
      type = AlertType.error;
    }

    if (response.statusCode == 200) {
      Alert(
        context: context,
        type: type,
        title: body['title'],
        desc: body['text'],
        buttons: [
          DialogButton(
            child: Text(
              body['button'],
              style: const TextStyle(color: Colors.white, fontSize: 20),
            ),
            onPressed: () {
              Navigator.pushAndRemoveUntil(
                context,
                MaterialPageRoute(
                  builder: (context) => SignIn(),
                ),
                (route) => false,
              );
            },
            width: 120,
          )
        ],
      ).show();
    }
  }

  _validasiInput() {
    if (_formKey.currentState!.validate()) {
      _formKey.currentState!.save();

      setState(() {
        _klik = true;
      });

      _addData();

      setState(() {
        _klik = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    _signInScreen() {
      return Scaffold(
        body: Center(
          child: ListView(
            shrinkWrap: true,
            children: <Widget>[
              Container(
                margin: EdgeInsets.only(top: 30),
                alignment: Alignment.center,
                child: Image.asset('assets/images/logo.png', width: 100),
              ),
              Card(
                margin: EdgeInsets.all(30),
                elevation: 3,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(25),
                ),
                child: Padding(
                  padding: EdgeInsets.all(40),
                  child: Form(
                    key: _formKey,
                    child: Column(
                      children: <Widget>[
                        Container(
                          padding: EdgeInsets.only(bottom: 30),
                          child: Text(
                            'SIGN UP',
                            style: TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF1C6758),
                            ),
                          ),
                        ),
                        TextFormField(
                          validator: _validasiNama,
                          controller: controllerNama,
                          decoration: InputDecoration(
                            labelText: 'Nama',
                            labelStyle: TextStyle(color: Colors.black87),
                            prefixIcon: Icon(
                              Icons.person_pin_rounded,
                              color: Color(0xFF1C6758),
                            ),
                            contentPadding: EdgeInsets.fromLTRB(20, 10, 0, 10),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                width: 2,
                                color: Color(0xFF1C6758),
                              ),
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                color: Color(0xFF1C6758),
                              ),
                            ),
                          ),
                        ),
                        SizedBox(height: 10),
                        TextFormField(
                          validator: _validasiEmail,
                          controller: controllerEmail,
                          keyboardType: TextInputType.emailAddress,
                          decoration: InputDecoration(
                            labelText: 'Email',
                            labelStyle: TextStyle(color: Colors.black87),
                            prefixIcon: Icon(
                              Icons.mail,
                              color: Color(0xFF1C6758),
                            ),
                            contentPadding: EdgeInsets.fromLTRB(20, 10, 0, 10),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                width: 2,
                                color: Color(0xFF1C6758),
                              ),
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                color: Color(0xFF1C6758),
                              ),
                            ),
                          ),
                        ),
                        SizedBox(height: 10),
                        TextFormField(
                          validator: _validasiUsername,
                          controller: controllerUsername,
                          decoration: InputDecoration(
                            labelText: 'Username',
                            labelStyle: TextStyle(color: Colors.black87),
                            prefixIcon: Icon(
                              Icons.account_box,
                              color: Color(0xFF1C6758),
                            ),
                            contentPadding: EdgeInsets.fromLTRB(20, 10, 0, 10),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                width: 2,
                                color: Color(0xFF1C6758),
                              ),
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                color: Color(0xFF1C6758),
                              ),
                            ),
                          ),
                        ),
                        SizedBox(height: 10),
                        TextFormField(
                          validator: _validasiPassword,
                          controller: controllerPassword,
                          obscureText: true,
                          decoration: InputDecoration(
                            labelText: 'Password',
                            labelStyle: TextStyle(color: Colors.black87),
                            prefixIcon: Icon(
                              Icons.lock,
                              color: Color(0xFF1C6758),
                            ),
                            suffixIcon: GestureDetector(
                              child: Icon(
                                Icons.visibility,
                                color: Color(0xFF1C6758),
                              ),
                              onTap: () {},
                            ),
                            contentPadding:
                                EdgeInsets.fromLTRB(20, 10, -20, 10),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                width: 2,
                                color: Color(0xFF1C6758),
                              ),
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(25),
                              borderSide: BorderSide(
                                color: Color(0xFF1C6758),
                              ),
                            ),
                          ),
                        ),
                        SizedBox(height: 30),
                        Material(
                          borderRadius: BorderRadius.circular(25),
                          color: Color(0xFF1C6758),
                          child: MaterialButton(
                            minWidth: double.infinity,
                            onPressed: _validasiInput,
                            child: _klik
                                ? CircularProgressIndicator()
                                : Icon(
                                    Icons.arrow_forward,
                                    color: Colors.white,
                                  ),
                          ),
                        ),
                        SizedBox(height: 15),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: <Widget>[
                            GestureDetector(
                              onTap: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) {
                                      return SignIn();
                                    },
                                  ),
                                );
                              },
                              child: Text(
                                'SIGN IN',
                                style: TextStyle(
                                  color: Color(0xFF1C6758),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      );
    }

    return _signInScreen();
  }
}
