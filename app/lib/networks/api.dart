import 'package:http/http.dart' as http;

class Network {
  // dev
  // final String _url = 'http://192.168.0.113/skripsi/SPC-KTE/web/api';
  // prod
  final String _url = 'http://192.168.43.113/skripsi/web/api';

  baseUrl() {
    return _url;
  }

  auth(data, apiUrl) async {
    var urlAuth = Uri.parse(_url + '/auth' + apiUrl);

    return await http.post(
      urlAuth,
      body: data,
    );
  }

  getAuthUser(id) async {
    var urlAuth = Uri.parse(_url + '/auth/user/' + id);

    return await http.get(
      urlAuth,
      headers: {"Accept": "application/json"},
    );
  }

  getKonsultasiById(id) async {
    var urlAuth = Uri.parse(_url + '/konsultasi/detail/' + id);

    return await http.get(
      urlAuth,
      headers: {"Accept": "application/json"},
    );
  }

  getKonsultasiResult(id) async {
    var urlAuth = Uri.parse(_url + '/konsultasi/result/' + id);

    return await http.get(
      urlAuth,
      headers: {"Accept": "application/json"},
    );
  }

  addKonsultasi(data) async {
    var urlAuth = Uri.parse(_url + '/konsultasi/save');

    return await http.post(
      urlAuth,
      body: data,
    );
  }
}
