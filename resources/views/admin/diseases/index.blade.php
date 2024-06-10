<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Diseases</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>Diseases</h1>
    <div style="margin-left: 1%">
        <a href="{{ route('admin.index') }}" class="btn">Home</a>
        <br><br>
        <a href="{{ route('diseases.create') }}">Add New Disease</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Symptoms</th>
                    <th>Additional Symptoms</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($diseases as $disease)
                    <tr>
                        <td>{{ $disease->id }}</td>
                        <td>{{ $disease->name }}</td>
                        <td>{{ $disease->description }}</td>
                        <td>
                            @foreach($disease->symptoms as $symptom)
                                {{ $symptom->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @php
                                $additionalSymptoms = is_string($disease->additional_symptoms) ? json_decode($disease->additional_symptoms, true) : [];
                            @endphp
                            @foreach($additionalSymptoms as $additionalSymptom)
                                {{ $additionalSymptom }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('diseases.edit', $disease->id) }}">Edit</a>
                            <br><br>
                            <form action="{{ route('diseases.destroy', $disease->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  
</body>
</html>
