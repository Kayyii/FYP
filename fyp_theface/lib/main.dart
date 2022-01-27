import 'package:flutter/material.dart';
import 'package:fyp_theface/pages/detection_home.dart';
import 'package:fyp_theface/pages/recognition_home.dart';

void main() => runApp(MaterialApp(
  initialRoute: '/',
  routes: <String, WidgetBuilder> {
    '/': (context) => const Home(),
    '/detection': (context) => const DetectionHome(),
    '/recognition': (context) => const RecognitionHome(),
  },
));

class Home extends StatelessWidget {
  const Home({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SafeArea(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Image.asset('assets/images/selfie.png'),
            ),
            Text(
              'Let\'s Play, Select One',
              style: TextStyle(
                fontFamily: 'Comfortaa',
                fontSize: 20.0,
                fontWeight: FontWeight.w900,
                color: Colors.indigo[800]
              ),
            ),
            const SizedBox( height: 16.0),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Card(
                color: Colors.grey[200],
                elevation: 0.0,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Container(
                      padding: const EdgeInsets.only( left: 16.0, right: 16.0, top: 16.0 ),
                      child: OutlinedButton(
                        onPressed: () {
                          Navigator.of(context).pushNamed('/detection');
                        },
                        style: OutlinedButton.styleFrom(
                          tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                          padding: const EdgeInsets.only(top: 20.0, bottom: 20.0),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
                          side: const BorderSide(
                            width: 2.5,
                            color: Colors.grey,
                          ),
                          primary: Colors.grey[800],
                          backgroundColor: Colors.white,
                        ),
                        child: const Text(
                          'AGE & GENDER DETECTION',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontFamily: 'M Plus 2',
                            letterSpacing: 2.0,
                            fontSize: 20.0,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                    Padding(
                      padding: const EdgeInsets.only( left: 16.0, right: 16.0, top: 16.0, bottom: 16.0),
                      child: OutlinedButton(
                        onPressed: () {
                          Navigator.of(context).pushNamed('/recognition');
                        },
                        style: OutlinedButton.styleFrom(
                          tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                          padding: const EdgeInsets.only(top: 20.0, bottom: 20.0),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
                          side: const BorderSide(
                            width: 2.5,
                            color: Colors.grey,
                          ),
                          primary: Colors.grey[800],
                          backgroundColor: Colors.white,
                        ),
                        child: const Text(
                          'CELEBRITY RECOGNITION',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontFamily: 'M Plus 2',
                            fontSize: 20.0,
                            letterSpacing: 3.0,
                            fontWeight: FontWeight.w700
                          ),
                        ),
                      ),
                    ),
                  ]
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
