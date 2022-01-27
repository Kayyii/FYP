import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:google_ml_vision/google_ml_vision.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:ui' as ui;
import 'dart:io';
import 'package:image/image.dart' as img;
import 'package:tflite_flutter/tflite_flutter.dart';
import 'package:tflite_flutter_helper/tflite_flutter_helper.dart';
import 'package:fyp_theface/widgets/my_painter.dart';

class DetectionHome extends StatefulWidget {
  const DetectionHome({ Key? key }) : super(key: key);

  @override
  _DetectionHomeState createState() => _DetectionHomeState();
}

class _DetectionHomeState extends State<DetectionHome> {

  bool isButtonEnabled = false;

  String _outputage = '';
  String _outputgender = '';
  bool _predloading = false;
  bool isPredicted = false;

  File? imageFile;
  ui.Image? _image;
  late GoogleVisionImage visionImage;
  List<Rect> rect = <Rect>[];
  bool imgLoading = false;
  final ImagePicker _picker = ImagePicker();
  
  void predData() async {

    setState(() {
      _predloading = true;
    });

    // int x = rect[0].left.round();
    // int y = rect[0].top.round();
    // int r = rect[0].right.round();
    // int b = rect[0].bottom.round();
    // int w = r - x;
    // int h = b - y;

    var image = img.decodeImage(imageFile!.readAsBytesSync())!;
    // img.Image croppedImage = img.copyCrop(image, x, y, w, h);
    img.Image croppedImage = img.copyResize(image, width: 96, height: 96);
    // croppedImage = img.grayscale(croppedImage);

    final interpreter = await Interpreter.fromAsset('agegender.tflite');
    
    var _inputShape = interpreter.getInputTensor(0).shape;
    var _inputType = interpreter.getInputTensor(0).type;
    // var _outputShape = interpreter.getOutputTensor(0).shape;
    // var _outputType = interpreter.getOutputTensor(0).type;

    // int padSize = max(inputImage.height, inputImage.width);
    ImageProcessor imageProcessor = ImageProcessorBuilder()
      // .add(ResizeWithCropOrPadOp(padSize, padSize))
      .add(NormalizeOp(127.5, 127.5))
      .add(ResizeOp(_inputShape[1], _inputShape[2], ResizeMethod.BILINEAR))
      .build();

    // TensorImage tensorImage = TensorImage.fromFile(imageFile!);
    TensorImage tensorImage = TensorImage(_inputType);
    // tensorImage = TensorImage.fromFile(imageFile);
    tensorImage.loadImage(croppedImage);
    tensorImage = imageProcessor.process(tensorImage);

    // crop image
      // Image imgIn = decodeJpg(File('images/input.jpg').readAsBytesSync());
      // Image imgResized = copyResize(imgIn, width: 320, height: 320);
      // TensorImage tensorImage = TensorImage.fromImage(imgResized);

    // TensorBuffer outputBuffer = TensorBuffer.createFixedSize(
    //   _outputShape,
    //   _outputType);

    TensorBuffer output0 = TensorBuffer.createFixedSize(
        interpreter.getOutputTensor(0).shape,
        interpreter.getOutputTensor(0).type);
    TensorBuffer output1 = TensorBuffer.createFixedSize(
        interpreter.getOutputTensor(1).shape,
        interpreter.getOutputTensor(1).type);

    Map<int, ByteBuffer> outputs = {0: output0.buffer, 1: output1.buffer};

    interpreter.runForMultipleInputs([tensorImage.buffer], outputs);

    List<double> gender = output0.getDoubleList();
    List<double> age = output1.getDoubleList();

    setState(() {
      _predloading = false;
      isPredicted = true;
      _outputgender = (gender[0] > 0.80) ? "Female" : "Male" ;
      _outputage = age[0].round().toString();
    });

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
      imgLoading = false;
    });
  }
  
  Future _imgFromCamera() async {
    final XFile? imagexFile = await _picker.pickImage( source: ImageSource.camera);
    imageFile = File(imagexFile!.path);
    setState(() {
      rect = <Rect>[];
      imgLoading = true;
      isPredicted = false;
      _outputage = '';
      _outputgender = '';
      isButtonEnabled = false;
    });
    detectFace(imageFile!);
  }

  Future _imgFromGallery() async {
    final XFile? imagexFile = await _picker.pickImage( source: ImageSource.gallery);
    imageFile = File(imagexFile!.path);
    setState(() {
      rect = <Rect>[];
      imgLoading = true;
      isPredicted = false;
      _outputage = '';
      _outputgender = '';
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
            'Age & Gender Detection',
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
            child: 
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  GestureDetector(
                    onTap: () {
                      _showPicker(context);
                    },
                    child: 
                    imgLoading ? 
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
                  const SizedBox(height: 30.0,),
                  isPredicted ?
                  Table(
                    defaultVerticalAlignment: TableCellVerticalAlignment.middle,
                    border: TableBorder.all(color: Colors.black12),
                    columnWidths: const <int, TableColumnWidth>{
                      0: IntrinsicColumnWidth(),
                      1: FixedColumnWidth(64),
                      2: FixedColumnWidth(64),
                    },
                    children: [
                      TableRow(children: [
                        TableCell( child: Padding(
                          padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                          child: Center(
                            child: Text('1',
                              style: TextStyle(
                                fontFamily: 'M Plus 2',
                                fontWeight: FontWeight.bold,
                                color: Colors.indigo[700]
                              )
                            )
                          ),
                        )),
                        TableCell(
                            child: Padding(
                          padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                          child:
                              Center(child: Text(_outputgender, textScaleFactor: 1.3, 
                                style: const TextStyle(
                                  fontFamily: 'M Plus 2'
                                ),),)
                        )),
                        TableCell(
                          child: Padding(
                          padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                          child:
                              Center(child: Text(_outputage, textScaleFactor: 1.3, 
                              style: const TextStyle(
                                  fontFamily: 'M Plus 2'
                                ),)),
                        )),
                      ]),
                    ])
                    : Container(),
                  const SizedBox(height: 30.0),
                  ElevatedButton(
                    child: const Text(
                      'START', 
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
                      predData()
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