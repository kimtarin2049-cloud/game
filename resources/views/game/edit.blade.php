<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลเกม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4 p-4">
                <h2 class="mb-4">✏️ แก้ไขข้อมูลเกม: {{ $game->topics }}</h2>

                <!-- ฟอร์มแก้ไขข้อมูล (ใช้ Method PUT) -->
                <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- ชื่อเกม -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อเกม (Topics)</label>
                        <input type="text" name="topics" class="form-control" value="{{ $game->topics }}" required>
                    </div>

                    <!-- รายละเอียด -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">รายละเอียด</label>
                        <textarea name="descriptions" class="form-control" rows="4" required>{{ $game->descriptions }}</textarea>
                    </div>

                    <!-- ราคา -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">ราคา (บาท)</label>
                        <input type="number" name="price" class="form-control" value="{{ $game->price }}" required>
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tags (คั่นด้วยคอมมา เช่น Action, RPG)</label>
                        <input type="text" name="tags" class="form-control" value="{{ $game->tags }}">
                    </div>

                    <!-- แพลตฟอร์มที่จัดจำหน่าย -->
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">ช่องทางการขาย</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="staem" value="1" {{ $game->staem == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Steam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="Epic_Games" value="1" {{ $game->Epic_Games == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Epic Games</label>
                        </div>
                    </div>

                    <!-- ปุ่มกด -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/') }}" class="btn btn-secondary px-4">🔙 กลับหน้าแรก</a>
                        <button type="submit" class="btn btn-success px-4">💾 บันทึกการแก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>