import 'package:flutter/material.dart';
import 'dart:ui' as ui;

class facePainter extends CustomPainter {
  ui.Image image;
  // List<Face> faces;
  List<Rect> rect;

  facePainter({ required this.image, required this.rect });

  @override
  void paint(Canvas canvas, Size size) {
    final Paint paint = Paint()
      ..style = PaintingStyle.stroke
      ..strokeWidth = 8.0
      ..color = Colors.yellow;

    canvas.drawImage(image, Offset.zero, Paint());
    // for (var i = 0; i < faces.length; i++) {
    //   canvas.drawRect(rects[i], paint);
    // }
    if (rect.isNotEmpty) {
      for (Rect rect in this.rect) {
        canvas.drawRect(rect, paint);
      }
    }
  }

  @override
  bool shouldRepaint(CustomPainter oldDelegate) {
    return false;
  }
  
}