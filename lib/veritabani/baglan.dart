import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' show get;

class Baglan {
  static Future<String> response({required String url}) async {
    final response = await get(
      Uri.parse(url),
      headers: {
        HttpHeaders.accessControlAllowOriginHeader: "*",
        HttpHeaders.accessControlAllowCredentialsHeader: "true",
        HttpHeaders.accessControlAllowMethodsHeader:
            "GET, POST, OPTIONS, DELETE, PUT",
        HttpHeaders.accessControlMaxAgeHeader: "86400",
      },
    );
    if (response.statusCode == 200) {
      return response.body;
    } else {
      return "";
    }
  }

  static Future<Map<String, dynamic>> map({required String url}) async {
    return json.decode(await response(url: url));
  }

  static Future<List> list({required String url}) async {
    return json.decode(await response(url: url));
  }
}