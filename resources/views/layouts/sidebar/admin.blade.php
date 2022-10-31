 <li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
         <i class="flaticon-013-checkmark"></i>
         <span class="nav-text">Home</span>
     </a>
 </li>
 <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
         <i class="flaticon-072-printer"></i>
         <span class="nav-text">Settings</span>
     </a>
     <ul aria-expanded="false">
         <li><a href="{{ route('settings.basic.index') }}">School Settings</a></li>
         <li><a href="{{ route('settings.sessions.index') }}">Sessions</a></li>
         <li><a href="{{ route('settings.sections.index') }}">School Sections</a></li>
         <li><a href="{{ route('settings.classes.index') }}">Classes</a></li>
         <li><a href="{{ route('settings.subjects.index') }}">Subjects</a></li>
         <li><a href="{{ route('settings.assign_subjects.index') }}">Subjects Assignment</a></li>

         <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Result Settings</a>
             <ul aria-expanded="false">
                 <li><a href="{{ route('settings.psychomotor_crud.index') }}">Psychomotor Skills</a></li>
                 <li><a href="{{ route('settings.affective_crud.index') }}">Affective Traits</a></li>
                 <li><a href="{{ route('settings.ca_scheme.index') }}">CA Scheme</a></li>
             </ul>
         </li>
         <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Fee Settings</a>
             <ul aria-expanded="false">
                 <li><a href="{{ route('settings.fee_category.index') }}">Fee Categories</a></li>
                 <li><a href="{{ route('settings.fee_structure.index') }}">Fee Structure</a></li>
             </ul>
         </li>
     </ul>
 </li>
 <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
         <i class="flaticon-072-printer"></i>
         <span class="nav-text">Users</span>
     </a>
     <ul aria-expanded="false">
         <li><a href="{{ route('users.students.index') }}">Students</a></li>
         <li><a href="{{ route('users.students.bulk_update.index') }}">Bulk Update</a></li>
     </ul>
 </li>
 <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
         <i class="flaticon-072-printer"></i>
         <span class="nav-text">Marks Entry</span>
     </a>
     <ul aria-expanded="false">
         <li><a href="{{ route('marks.create') }}">Enter Marks</a></li>
         <li><a href="{{ route('marks.grade_book.index') }}">Grade book</a></li>
         <li><a href="{{ route('marks.submissions.index') }}">Submissions</a></li>
     </ul>
 </li>
 <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
         <i class="flaticon-072-printer"></i>
         <span class="nav-text">Result Generation</span>
     </a>
     <ul aria-expanded="false">
         <li><a href="#">Progress Report</a></li>
         <li><a href="{{ route('result.termly.index') }}">End of Term Report</a></li>
         <li><a href="#">End of Ses. Report</a></li>
         <li><a href="#">Broadsheet</a></li>
         <li><a href="{{ route('comments.index') }}">Comments</a></li>
         <li><a href="{{ route('psychomotor.index') }}">Psychomotor/Affective</a></li>
         <li><a href="#">Early Year's Result</a></li>
         <li><a href="#">Result Analysis</a></li>
         <li><a href="#">Publish Result</a></li>
         <li><a href="{{ route('result.settings') }}">Result Settings</a></li>
     </ul>
 </li>

 <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
         <i class="flaticon-072-printer"></i>
         <span class="nav-text">Fees & Billing</span>
     </a>
     <ul aria-expanded="false">
         <li><a href="{{ route('fee_collection.index') }}">Collect Fee</a></li>
         <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
         <li><a href="{{ route('expenses.index') }}">Expenses</a></li>
         
     </ul>
 </li>
