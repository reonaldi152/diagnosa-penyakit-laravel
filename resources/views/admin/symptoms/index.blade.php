<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Symptoms</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>Symptoms</h1>
    <div style="margin-left: 3%">
        <a href="{{ route('admin.index') }}" class="btn">Home</a>
        <br><br>
        <a href="{{ route('symptoms.create') }}">Add New Symptom</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($symptoms as $symptom)
                    <tr>
                        <td>{{ $symptom->id }}</td>
                        <td>{{ $symptom->name }}</td>
                        <td>
                            <a href="{{ route('symptoms.edit', $symptom->id) }}">Edit</a>
                            <br><br>
                            <form action="{{ route('symptoms.destroy', $symptom->id) }}" method="POST" style="display:inline;">
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
