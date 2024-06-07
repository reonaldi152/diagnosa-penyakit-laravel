<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($disease) ? 'Edit Disease' : 'Add New Disease' }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>{{ isset($disease) ? 'Edit Disease' : 'Add New Disease' }}</h1>
    <form action="{{ isset($disease) ? route('diseases.update', $disease->id) : route('diseases.store') }}" method="POST">
        @csrf
        @if(isset($disease))
            @method('PUT')
        @endif
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ isset($disease) ? $disease->name : '' }}" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required>{{ isset($disease) ? $disease->description : '' }}</textarea>

        <label for="symptoms">Symptoms:</label>
        <select id="symptoms" name="symptoms[]" multiple required>
            @foreach($symptoms as $symptom)
                <option value="{{ $symptom->id }}" {{ isset($disease) && $disease->symptoms->contains($symptom->id) ? 'selected' : '' }}>
                    {{ $symptom->name }}
                </option>
            @endforeach
        </select>

        <label for="additional_symptoms">Additional Symptoms:</label>
        <div id="additional-symptoms-container">
            @if(isset($disease) && is_string($disease->additional_symptoms))
                @foreach(json_decode($disease->additional_symptoms, true) ?? [] as $additionalSymptom)
                    <input type="text" name="additional_symptoms[]" value="{{ $additionalSymptom }}">
                @endforeach
            @else
                <input type="text" name="additional_symptoms[]">
            @endif
        </div>
        <button type="button" onclick="addAdditionalSymptom()">Add Additional Symptom</button>

        <button type="submit">{{ isset($disease) ? 'Update' : 'Add' }}</button>
    </form>

    <script>
        function addAdditionalSymptom() {
            const container = document.getElementById('additional-symptoms-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'additional_symptoms[]';
            container.appendChild(input);
        }
    </script>
</body>
</html>
