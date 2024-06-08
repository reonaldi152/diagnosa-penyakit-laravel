<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($symptom) ? 'Edit Symptom' : 'Add New Symptom' }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>{{ isset($symptom) ? 'Edit Symptom' : 'Add New Symptom' }}</h1>
    <form action="{{ isset($symptom) ? route('symptoms.update', $symptom->id) : route('symptoms.store') }}" method="POST">
        @csrf
        @if(isset($symptom))
            @method('PUT')
        @endif
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ isset($symptom) ? $symptom->name : '' }}" required>
        <button type="submit">{{ isset($symptom) ? 'Update' : 'Add' }}</button>
    </form>
</body>
</html>
