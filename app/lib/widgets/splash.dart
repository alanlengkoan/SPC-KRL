import 'package:animated_splash_screen/animated_splash_screen.dart';
import 'package:egg_detection/auth/sign_in/view.dart';
import 'package:flutter/material.dart';

class Splash extends StatefulWidget {
  const Splash({Key? key}) : super(key: key);

  @override
  State<Splash> createState() => _SplashState();
}

class _SplashState extends State<Splash> {
  _splashIcon() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Image.asset(
            'assets/images/logo.png',
            height: 61,
            width: 61,
          ),
          Container(
            child: const Text(
              'EDA',
              style: TextStyle(
                fontSize: 18,
                color: Color(0xFF1C6758),
              ),
            ),
          )
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedSplashScreen(
      splash: _splashIcon(),
      duration: 3000,
      splashTransition: SplashTransition.fadeTransition,
      backgroundColor: Colors.white,
      nextScreen: SignIn(),
    );
  }
}
