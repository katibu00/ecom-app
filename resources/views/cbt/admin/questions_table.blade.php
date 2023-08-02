<div class="table-responsive text-nowrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $key => $question)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{!! $question->question !!}</td>
                <td>
                    @if($question->options)
                        @php
                            $options = json_decode($question->options);
                            $optionLetters = ['a', 'b', 'c', 'd', 'e', 'f'];
                        @endphp
                        @foreach($options as $index => $option)
                            <p>{{ $optionLetters[$index] }}) {{ $option }}</p>
                        @endforeach
                    @endif
                </td>
                <td>{{ $question->correct_answer }}</td>
                <td>
                    <a href="{{ route('cbt.questions.edit', ['question' => $question->id]) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-danger" onclick="deleteQuestion({{ $question->id }})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
