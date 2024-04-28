import 'dart:convert';

import 'package:seaweed_detection/auth/sign_in/view.dart';
import 'package:seaweed_detection/networks/api.dart';
import 'package:seaweed_detection/pages/home.dart';
import 'package:seaweed_detection/widgets/splash.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SDA', 
      debugShowCheckedModeBanner: false,
      home: CheckAuth(),
    );
  }
}

class CheckAuth extends StatefulWidget {
  @override
  State<CheckAuth> createState() => CheckAuthState();
}

class CheckAuthState extends State<CheckAuth> {
  void _checkIfLoggedIn() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    var idUsers = preferences.getString('id_users');

    if (idUsers != null && idUsers.isNotEmpty && idUsers != '') {
      var response = await Network().getAuthUser(idUsers.toString());
      var body = json.decode(response.body);
      print(body);
      if (response.statusCode == 200) {
        if (body['status']) {
          String nama = body['data']['nama'];
          String email = body['data']['email'];
          bool status = body['data']['status'];

          setState(() {
            _checkSession(idUsers, nama, email, status);
          });
        } else {
          preferences.remove("id_users");
          preferences.remove("nama");
          preferences.remove("email");
          preferences.remove("status");

          Navigator.pushAndRemoveUntil(context, MaterialPageRoute(
            builder: (context) {
              return SignIn();
            },
          ), (route) => false);
        }
      } else {
        throw Exception('Maaf gagal mengambil data!');
      }
    } else {
      Navigator.pushAndRemoveUntil(context, MaterialPageRoute(
        builder: (context) {
          return SignIn();
        },
      ), (route) => false);
    }
  }

  _checkSession(String idUsers, String nama, String email, bool status) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    setState(
      () {
        preferences.setString("id_users", idUsers);
        preferences.setString("nama", nama);
        preferences.setString("email", email);
        preferences.setBool("status", status);

        Navigator.pushAndRemoveUntil(context, MaterialPageRoute(
          builder: (context) {
            return Home();
          },
        ), (route) => false);
      },
    );
  }

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration(seconds: 3), () {
      _checkIfLoggedIn();
    });
  }

  @override
  Widget build(BuildContext context) {
    return const Splash();
  }
}
