<div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
      <thead>
        <tr class="text-nowrap">
          <th >#</th>
          <th>Student</th>
          <th>Class</th>
          <th class="text-center">Outstanding (&#8358;)</th>
        </tr>
      </thead>
      <tbody>
       
       @foreach ($incompletePayments as $key => $student)
           @php
               $current_student = App\Models\User::select('id','first_name','middle_name','last_name','class_id')->where('id',$student->student_id)->first();
           @endphp
          <tr>
           
            <td>{{ $key+1}}</td>
            <td>{{ $current_student->first_name.' '.$current_student->middle_name.' '.$current_student->last_name }}</td>
            <td>{{ $current_student->class_id }}</td>
           
            <td class="text-center">{{ number_format($student->remaining,0) }}</td>
           
          </tr> 
         
          @endforeach

      </tbody>
    </table>
  </div>