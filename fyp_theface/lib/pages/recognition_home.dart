import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_ml_vision/google_ml_vision.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:ui' as ui;
import 'dart:io';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:tflite/tflite.dart';
import 'package:fyp_theface/widgets/my_painter.dart';
import 'package:url_launcher/url_launcher.dart';

class RecognitionHome extends StatefulWidget {
  const RecognitionHome({ Key? key }) : super(key: key);

  @override
  _RecognitionHomeState createState() => _RecognitionHomeState();
}

class _RecognitionHomeState extends State<RecognitionHome> {
  bool isButtonEnabled = false;

  List? _output;
  String? _url;
  bool _predloading = false;
  bool isPredicted = false;

  File? imageFile;
  ui.Image? _image;
  late GoogleVisionImage visionImage;
  List<Rect> rect = <Rect>[];
  bool isLoading = false;
  final ImagePicker _picker = ImagePicker();
  
  @override
  void initState() {
    super.initState();
    loadModel();
  }

  @override
  void dispose() async {
    super.dispose();
    await Tflite.close();
  }
  
  void _launchURL(String? url) async {
    if (!await launch(_url!)) throw 'Could not launch $_url';
  }

  classifyImage(File image) async {
    setState(() {
      _predloading = true;
    });
    var output = await Tflite.runModelOnImage(
      path: image.path,
      numResults: 30,
      threshold: 0.5,
      imageMean: 127.5,
      imageStd: 127.5,
    );

    setState(() {
      _output = output;
      _predloading = false;
      isPredicted = true;
    });
  }

  loadModel() async {
    await Tflite.loadModel(
      model: 'assets/celebrity.tflite',
      labels: 'assets/labels.txt'
    );
  }

  void detectFace(File image) async {
    final data = await imageFile!.readAsBytes();
    await decodeImageFromList(data).then(
    (value) => setState(() {
        _image = value;
      }),
    );
    visionImage = GoogleVisionImage.fromFile(imageFile!);

    final FaceDetector faceDetector = GoogleVision.instance.faceDetector(const FaceDetectorOptions());
    final List<Face> _faces = await faceDetector.processImage(visionImage);

    for (Face face in _faces) {
      rect.add(face.boundingBox);
    }

    if (_faces.isNotEmpty && _faces.length == 1) {
      setState(() {
        isButtonEnabled = true;
      });
    }
    faceDetector.close();
    setState(() {
      isLoading = false;
    });
  }

  Future _imgFromCamera() async {
    final XFile? imagexFile = await _picker.pickImage( source: ImageSource.camera);
    imageFile = File(imagexFile!.path);
    setState(() {
      rect = <Rect>[];
      isLoading = true;
      isPredicted = false;
      _output = [];
      isButtonEnabled = false;
    });
    detectFace(imageFile!);
  }

  Future _imgFromGallery() async {
    final XFile? imagexFile = await _picker.pickImage( source: ImageSource.gallery);
    imageFile = File(imagexFile!.path);
    setState(() {
      rect = <Rect>[];
      isLoading = true;
      isPredicted = false;
      _output = [];
      isButtonEnabled = false;
    });
    detectFace(imageFile!);
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        appBar: AppBar(
          title: const Text(
            'Celebrity Recognition',
            style: TextStyle(
              fontFamily: 'M Plus 2',
              fontSize: 20.0,
              fontWeight: FontWeight.bold
            ),
          ),
          centerTitle: true,
          backgroundColor: Colors.indigo[800],
          automaticallyImplyLeading: false,
          elevation: 0.0,
        ),
        body: Center(
          child: _predloading ? 
          SpinKitWave(
            color: Colors.indigo[800],
            size: 50.0,
          )
          :
          SingleChildScrollView(
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                // mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  GestureDetector(
                    onTap: () {
                      _showPicker(context);
                    },
                    child: 
                    isLoading ? 
                    const Center(child: CircularProgressIndicator()) 
                    : 
                    (imageFile != null) ?
                      (rect.isEmpty) ?
                        Image.file(
                          imageFile!,
                          fit: BoxFit.cover,
                        )
                        :
                        FittedBox(
                          child: SizedBox(
                            width: _image != null ? _image!.width.toDouble() : 500.0,
                            height: _image != null ? _image!.height.toDouble() : 500.0,
                            child: CustomPaint(
                              painter: facePainter(image: _image!, rect: rect),
                            )
                          )
                        ) 
                      :
                      Image.asset(
                        'assets/images/placeholder.jpg',
                        fit: BoxFit.cover,
                      ),
                  ),
                    (isPredicted) ?
                      (_output![0]['label'] != 'Unknown Person') ? 
                        ListTile(
                          leading: CircleAvatar(
                            radius: 11,
                            backgroundColor: Colors.grey[800],
                            backgroundImage: null,
                            child: const Text('1', textScaleFactor: 1.2, style: TextStyle(color: Colors.white)),
                          ),
                          title: Text('${_output![0]['label']}', textScaleFactor: 1.2,style: const TextStyle(fontFamily: 'M Plus 2'),),
                          trailing: GestureDetector(
                            child: const Icon(Icons.person_search), 
                            onTap: () => setState(() {
                              _url = "https://www.google.com/search?q=${_output![0]['label']}";
                              _launchURL(_url);
                            })
                          ),
                          onLongPress: () { 
                            Clipboard.setData(
                              ClipboardData(text: '${_output![0]['label']}'),
                            );
                            ScaffoldMessenger.of(context).showSnackBar(const SnackBar(
                              content: Text("Copied text!"),
                            ));
                          },
                        )
                        :
                        ListTile(
                          leading: CircleAvatar(
                            radius: 11,
                            backgroundColor: Colors.grey[800],
                            backgroundImage: null,
                            child: const Text('1', textScaleFactor: 1.2, style: TextStyle(color: Colors.white)),
                          ),
                          title: Text('${_output![0]['label']}', textScaleFactor: 1.2,style: const TextStyle(fontFamily: 'M Plus 2'),),
                        )
                    : Container(),
                  const SizedBox(height: 30.0),
                  ElevatedButton(
                    child: const Text(
                      'RECOGNIZE', 
                      style: TextStyle(
                        fontSize: 20.0,
                        fontFamily: 'Comfortaa',
                        fontWeight: FontWeight.w800,
                        letterSpacing: 3.0,
                      )
                    ),
                    style: ElevatedButton.styleFrom(
                      primary: Colors.indigo[800],
                      padding: const EdgeInsets.symmetric(horizontal: 50.0, vertical: 25.0),
                    ),
                    onPressed: () {
                      isButtonEnabled ? 
                      classifyImage(imageFile!)
                      :
                      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(
                        content: Text("* Please select a photo that contain face \n* One time one person."),
                      ));
                    }  
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  void _showPicker(context) {
    showModalBottomSheet(
      context: context,
      builder: (BuildContext bc) {
        return SafeArea(
          child: Wrap(
            children: <Widget>[
              ListTile(
                  leading: const Icon(Icons.photo_library),
                  title: const Text('Gallery'),
                  onTap: () {
                    _imgFromGallery();
                    Navigator.of(context).pop();
                  }),
              ListTile(
                leading: const Icon(Icons.photo_camera),
                title: const Text('Camera'),
                onTap: () {
                  _imgFromCamera();
                  Navigator.of(context).pop();
                },
              ),
            ],
          ),
        );
      }
    );
  }
}