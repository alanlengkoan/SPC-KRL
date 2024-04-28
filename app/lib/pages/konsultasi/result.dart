import 'package:seaweed_detection/networks/api.dart';
import 'package:seaweed_detection/pages/home.dart';
import 'package:flutter/material.dart';
import 'dart:convert';

class ResultKonsultasi extends StatefulWidget {
  const ResultKonsultasi({Key? key, required this.title, required this.id})
      : super(key: key);

  final String title;
  final String id;

  @override
  State<ResultKonsultasi> createState() => _ResultKonsultasiState();
}

class _ResultKonsultasiState extends State<ResultKonsultasi> {
  Map konsultasi = {};

  _getData() async {
    var response = await Network().getKonsultasiResult(widget.id);
    var body = json.decode(response.body);
    print(body);
    if (response.statusCode == 200) {
      var data = json.decode(response.body);

      setState(() {
        konsultasi = data;
      });
    } else {
      throw Exception('Maaf gagal mengambil data!');
    }
  }

  @override
  void initState() {
    super.initState();
    _getData();
  }

  @override
  Widget build(BuildContext context) {
    _show() {
      return SingleChildScrollView(
        child: Column(
          children: <Widget>[
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Nama :',
                  ),
                ),
                Container(
                  child: Text(
                    konsultasi['nama'],
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Klasifikasi :',
                  ),
                ),
                Container(
                  child: Text(
                    konsultasi['classification'],
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Deskripsi :',
                  ),
                ),
                Expanded(
                  child: Text(
                    konsultasi['descripton'],
                    textAlign: TextAlign.justify,
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Contrast :',
                  ),
                ),
                Expanded(
                  child: Text(
                    konsultasi['contrast'].toString(),
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Correlation :',
                  ),
                ),
                Expanded(
                  child: Text(
                    konsultasi['correlation'].toString(),
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Energy :',
                  ),
                ),
                Expanded(
                  child: Text(
                   konsultasi['energy'].toString(),
                  ),
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Container(
                  margin: EdgeInsets.all(25.0),
                  child: Text(
                    'Homogeneity :',
                  ),
                ),
                Expanded(
                  child: Text(
                     konsultasi['homogeneity'].toString(),
                  ),
                ),
              ],
            ),
          ],
        ),
      );
    }

    _loading() {
      return const Center(
        child: CircularProgressIndicator(),
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
        centerTitle: true,
        backgroundColor: const Color(0xFF1C6758),
        leading: Padding(
          padding: const EdgeInsets.only(left: 5.0),
          child: GestureDetector(
            onTap: () {
              Navigator.pushAndRemoveUntil(context, MaterialPageRoute(
                builder: (context) {
                  return Home();
                },
              ), (route) => false);
            },
            child: const Icon(
              Icons.arrow_back,
              size: 26.0,
            ),
          ),
        ),
      ),
      body: Container(
        margin: const EdgeInsets.all(15),
        child: konsultasi.isEmpty ? _loading() : _show(),
      ),
    );
  }
}
