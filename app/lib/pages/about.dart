import 'package:flutter/material.dart';

class About extends StatefulWidget {
  const About({Key? key, required this.title}) : super(key: key);

  final String title;

  @override
  State<About> createState() => _AboutState();
}

class _AboutState extends State<About> {
  @override
  Widget build(BuildContext context) {
    _aboutScreen() {
      return ListView(
        children: <Widget>[
          Container(
            child: Column(
              children: <Widget>[
                Image.asset(
                  'assets/images/cover.jpg',
                  fit: BoxFit.cover,
                ),
                Container(
                  margin: const EdgeInsets.only(top: 20, bottom: 20),
                  child: const Text(
                    'Seawed Detected Application ( SDA) merupakan sebuah sistem yang digunakan untuk mengetahui kualitas rumput laut berdasarkan tingkatan kelas sehingga mempermudah proses export.',
                    textAlign: TextAlign.justify,
                  ),
                ),
              ],
            ),
          ),
        ],
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
        centerTitle: true,
        backgroundColor: const Color(0xFF1C6758),
      ),
      body: Container(
        margin: const EdgeInsets.all(15),
        child: _aboutScreen(),
      ),
    );
  }
}
