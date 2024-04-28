import 'package:carousel_slider/carousel_slider.dart';
import 'package:seaweed_detection/pages/about.dart';
import 'package:seaweed_detection/pages/konsultasi/view.dart';
import 'package:seaweed_detection/widgets/nav-drawer.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  List<String> imgList = [
    'assets/slide/slide1.jpg',
    'assets/slide/slide2.jpg',
    'assets/slide/slide3.jpg',
  ];

  String idUsers = '';
  String nama = '';
  String email = '';

  _loadUserData() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    setState(() {
      idUsers = preferences.getString('id_users') ?? '';
      nama = preferences.getString('nama') ?? '';
      email = preferences.getString('email') ?? '';
    });
  }

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Widget build(BuildContext context) {
    _homeScreen() {
      return Center(
        child: Column(
          children: <Widget>[
            CarouselSlider(
              options: CarouselOptions(
                enlargeCenterPage: true,
                aspectRatio: 2.0,
                autoPlay: true,
              ),
              items: imgList
                  .map(
                    (item) => Image.asset(item, fit: BoxFit.cover, width: 1000),
                  )
                  .toList(),
            ),
            Container(
              margin: const EdgeInsets.only(top: 20),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  Card(
                    child: InkWell(
                      splashColor: Color(0xFF1C6758).withAlpha(30),
                      onTap: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => About(
                              title: "About",
                            ),
                          ),
                        );
                      },
                      child: const SizedBox(
                        width: 150,
                        height: 100,
                        child: Icon(
                          Icons.info,
                          color: Color(0xFF1C6758),
                          size: 70,
                        ),
                      ),
                    ),
                  ),
                  Card(
                    child: InkWell(
                      splashColor: Color(0xFF1C6758).withAlpha(30),
                      onTap: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => Konsultasi(
                              title: "Konsultasi",
                            ),
                          ),
                        );
                      },
                      child: const SizedBox(
                        width: 150,
                        height: 100,
                        child: Icon(
                          Icons.add,
                          color: Color(0xFF1C6758),
                          size: 70,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      );
    }

    return Scaffold(
        drawer: NavDrawer(
          nama: nama,
          email: email,
        ),
        appBar: AppBar(
          title: Text('SDA'),
          centerTitle: true,
          backgroundColor: const Color(0xFF1C6758),
        ),
        body: Container(
          margin: const EdgeInsets.all(15),
          child: _homeScreen(),
        ));
  }
}
