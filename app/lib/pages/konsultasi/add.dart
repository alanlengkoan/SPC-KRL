import 'dart:io';

import 'package:seaweed_detection/networks/api.dart';
import 'package:seaweed_detection/pages/konsultasi/result.dart';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:rflutter_alert/rflutter_alert.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:tflite/tflite.dart';
import 'dart:convert';

class AddKonsultasi extends StatefulWidget {
  const AddKonsultasi({Key? key, required this.title}) : super(key: key);
  final String title;

  @override
  State<AddKonsultasi> createState() => _AddKonsultasiState();
}

class _AddKonsultasiState extends State<AddKonsultasi> {
  final _formKey = GlobalKey<FormState>();

  var picker = ImagePicker();
  var _imageUpload;
  final listOutputs = [];
  var _validasiImageUpload = const Text('Belum ada gambar yang diambil!');
  var tfResponse;
  var _label;

  bool _loadingLoad = true;
  // untuk load model
  Future loadModel() async {
    try {
      tfResponse = await Tflite.loadModel(
        model: 'assets/tflite/model_unquant.tflite',
        labels: 'assets/tflite/labels.txt',
      );
      print('Berhasil load model: $tfResponse');
    } catch (e) {
      print('Gagal load model: $e');
    }
  }

  // untuk upload atau ambil gambar
  void _uploadOrTakeImage(ImageSource imageSource) async {
    var imageUpload = await picker.pickImage(source: imageSource);

    setState(() {
      _imageUpload = File(imageUpload!.path);
      _validasiImageUpload = const Text('');
    });

    processImage(_imageUpload);
  }

  // untuk memproses gambar
  void processImage(File image) async {
    var output = await Tflite.runModelOnImage(
      path: image.path,
      numResults: 2,
      threshold: 0.5,
      imageMean: 127.5,
      imageStd: 127.5,
    );
    setState(() {
      listOutputs.clear();
      listOutputs.addAll(output!);

      _label = listOutputs[0]['label']
          .toString()
          .replaceAll(RegExp(r'[0-9]'), '')
          .toUpperCase()
          .trim();
    });
  }

  _addData() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    String nameImage = _imageUpload!.path.split("/").last;
    String imageLoc = base64Encode(_imageUpload!.readAsBytesSync());

    if (_label == 'BUKAN RUMPUT LAUT') {
      Alert(
        context: context,
        type: AlertType.error,
        title: 'Gagal',
        desc: 'Gambar bukan rumput laut!',
        buttons: [
          DialogButton(
            child: Text(
              'OK',
              style: const TextStyle(color: Colors.white, fontSize: 20),
            ),
            onPressed: () {
              Navigator.pop(context);
            },
            width: 120,
          )
        ],
      ).show();
    } else {
      var data = {
        "id_users": preferences.getString('id_users'),
        "image": nameImage,
        "loc_image": imageLoc,
      };

      var response = await Network().addKonsultasi(data);
      var body = json.decode(response.body);
      if (response.statusCode == 200) {
        if (body['status']) {
          Alert(
            context: context,
            type: AlertType.success,
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
                      builder: (context) => ResultKonsultasi(
                        title: "Hasil Konsultasi",
                        id: body['id'].toString(),
                      ),
                    ),
                    (route) => false,
                  );
                },
                width: 120,
              )
            ],
          ).show();
        } else {
          Alert(
            context: context,
            type: AlertType.error,
            title: body['title'],
            desc: body['text'],
            buttons: [
              DialogButton(
                child: Text(
                  body['button'],
                  style: const TextStyle(color: Colors.white, fontSize: 20),
                ),
                onPressed: () {
                  Navigator.pop(context);
                },
                width: 120,
              )
            ],
          ).show();
        }
      }
    }
  }

  void _validasiInput() {
    if (_formKey.currentState!.validate() && _imageUpload != null) {
      _formKey.currentState!.save();
      setState(() {
        _loadingLoad = false;
      });

      _addData();

      setState(() {
        _loadingLoad = true;
      });
    } else {
      setState(() {
        _validasiImageUpload = const Text('Belum ada gambar yang diambil!',
            style: TextStyle(color: Colors.red));
      });
    }
  }

  @override
  void initState() {
    loadModel().then((value) {
      setState(() {});
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    _form() {
      return CustomScrollView(
        slivers: <Widget>[
          SliverList(
            delegate: SliverChildListDelegate([
              Form(
                key: _formKey,
                autovalidateMode: AutovalidateMode.onUserInteraction,
                child: Column(
                  children: <Widget>[
                    Container(
                      padding: const EdgeInsets.only(top: 10),
                      child: Column(
                        children: <Widget>[
                          Row(
                            children: <Widget>[
                              Container(
                                padding: const EdgeInsets.only(
                                    right: 10, top: 10, bottom: 10),
                                child: ElevatedButton(
                                  style: ButtonStyle(
                                    backgroundColor:
                                        MaterialStateProperty.all<Color>(
                                            Colors.blue),
                                  ),
                                  onPressed: () =>
                                      _uploadOrTakeImage(ImageSource.gallery),
                                  child: Container(
                                    child: Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      children: const <Widget>[
                                        Text("Upload Gambar",
                                            style:
                                                TextStyle(color: Colors.white))
                                      ],
                                    ),
                                  ),
                                ),
                              ),
                              Container(
                                padding: const EdgeInsets.only(
                                    right: 10, top: 10, bottom: 10),
                                child: ElevatedButton(
                                  style: ButtonStyle(
                                    backgroundColor:
                                        MaterialStateProperty.all<Color>(
                                            Colors.green),
                                  ),
                                  onPressed: () =>
                                      _uploadOrTakeImage(ImageSource.camera),
                                  child: Container(
                                    child: Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      children: const <Widget>[
                                        Text("Ambil Gambar",
                                            style:
                                                TextStyle(color: Colors.white))
                                      ],
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                          listOutputs.isEmpty
                              ? Text(
                                  'Silahkan upload atau ambil gambar terlebih dahulu!')
                              : Text(''),
                          Container(
                            margin: EdgeInsets.only(top: 5),
                            width: MediaQuery.of(context).size.width,
                            height: 400,
                            decoration: const BoxDecoration(color: Colors.grey),
                            child: _imageUpload != null
                                ? Image.file(
                                    _imageUpload,
                                    fit: BoxFit.fitHeight,
                                  )
                                : Container(
                                    decoration:
                                        const BoxDecoration(color: Colors.grey),
                                    child: Icon(
                                      Icons.camera_alt,
                                      color: Colors.grey[800],
                                    ),
                                  ),
                          ),
                          Container(
                            child: _imageUpload == null
                                ? _validasiImageUpload
                                : _validasiImageUpload,
                          ),
                          Container(
                            margin: EdgeInsets.only(top: 20),
                            child: Material(
                              borderRadius: BorderRadius.circular(25),
                              child: MaterialButton(
                                minWidth: double.infinity,
                                onPressed: _validasiInput,
                                disabledTextColor: Colors.black,
                                disabledColor: Colors.black26,
                                textColor: Colors.white,
                                color: Color(0xFF1C6758),
                                child: Text(
                                  'PROSES',
                                  style: TextStyle(
                                    // color: Colors.white,
                                    fontSize: 15,
                                  ),
                                ),
                              ),
                            ),
                          )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ]),
          ),
        ],
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
      ),
      body: Container(
        margin: const EdgeInsets.all(15),
        child: _loadingLoad ? _form() : _loading(),
      ),
    );
  }
}
