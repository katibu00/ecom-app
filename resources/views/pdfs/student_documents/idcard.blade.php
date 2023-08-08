<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ID Card</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f0f0f0;
    }

    .id-card-container {
      display: flex;
      align-items: center;
    }

    .id-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin: 10px;
      max-width: 300px; /* Adjust the width as needed */
      width: 100%;
      text-align: center;
    }

    .front {
      border-top: 4px solid #007bff;
    }

    .back {
      border-top: 4px solid #dc3545;
    }

    .photo img {
      max-width: 120px;
      border-radius: 50%;
      border: 4px solid #007bff;
      margin: 10px auto;
      display: block;
    }

    .user-info h2 {
      margin-bottom: 5px;
      font-size: 24px;
      color: #007bff;
    }

    .designation, .school, .admission-number, .dob, .parent-name {
      margin: 0;
      font-size: 14px;
      color: #777;
    }

    .school-info {
      margin-bottom: 20px;
    }

    .school-name {
      font-size: 24px;
      font-weight: bold;
      color: #007bff;
    }

    .school-address, .school-website {
      margin: 0;
      font-size: 12px;
      color: #777;
    }

    .additional-info {
      text-align: left;
    }

    .additional-info p {
      margin: 5px 0;
    }

    .qr-code {
      height: 100px;
      width: 100px;
      margin: 10px auto;
      border: 1px dashed #ccc;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .qr-code:before {
      content: "Scan QR Code";
      font-size: 12px;
      color: #777;
    }

    .emergency-contact, .portal-info {
      margin-top: 20px;
      font-size: 12px;
      color: #777;
    }

    /* Media Query for Responsiveness */
    @media (max-width: 768px) {
      .id-card-container {
        flex-direction: column;
      }
      .id-card {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
    <div class="id-card-container">
        @foreach($students as $student)
        <div class="id-card front">
          <div class="school-info">
            <h2 class="school-name">{{ $school->name }}</h2>
            <p class="school-address">{{ $school->address }}</p>
            <p class="school-website">{{ $school->website }}</p>
          </div>
          <div class="photo">
            <img src="{{ $student->image !== null ? asset('uploads/'.$school->username.'/'.$student->image) : asset('uploads/default.png') }}" alt="{{ $student->first_name }} Photo">
        </div>
          <div class="user-info">
            <h2 class="name">{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name }}</h2>
            <p class="designation">Student</p>
            <p class="admission-number">Admission Number: {{ @$student->login }}</p>
            <p class="dob">Date of Birth: {{ @$student->dob }}</p>
            <p class="parent-name">Parent Name: {{ @$student->parent->first_name }}</p>
          </div>
    
        </div>
    
        <div class="id-card back">
          <div class="qr-code">
            <!-- QR code placeholder or real QR code image can be added here -->
          </div>
          <div class="emergency-contact">
            <p>Emergency Contact: {{ @$student->parent->address }}</p>
          </div>
          <div class="portal-info">
            <p>Portal URL: {{ $school->portal_url }}</p>
            <p>Access Code: {{ @$student->portal_access_code }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </body>
</html>
