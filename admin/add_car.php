<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getPDO();

    // Sanitize inputs
    $brand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING) ?? '';
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING) ?? '';
    $registration_year = filter_input(INPUT_POST, 'registration_year', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $mileage = filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $seats = filter_input(INPUT_POST, 'seats', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $doors = filter_input(INPUT_POST, 'doors', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $fuel_type = filter_input(INPUT_POST, 'fuel_type', FILTER_SANITIZE_STRING) ?? '';
    $fuel_consumption = filter_input(INPUT_POST, 'fuel_consumption', FILTER_SANITIZE_STRING) ?? '';
    $co2_emissions = filter_input(INPUT_POST, 'co2_emissions', FILTER_SANITIZE_STRING) ?? '';
    $power = filter_input(INPUT_POST, 'power', FILTER_SANITIZE_STRING) ?? '';
    $top_speed = filter_input(INPUT_POST, 'top_speed', FILTER_SANITIZE_STRING) ?? '';
    $acceleration = filter_input(INPUT_POST, 'acceleration', FILTER_SANITIZE_STRING) ?? '';
    $gearbox = filter_input(INPUT_POST, 'gearbox', FILTER_SANITIZE_STRING) ?? '';
    $engine_capacity = filter_input(INPUT_POST, 'engine_capacity', FILTER_SANITIZE_STRING) ?? '';
    $fuel_tank_capacity = filter_input(INPUT_POST, 'fuel_tank_capacity', FILTER_SANITIZE_STRING) ?? '';
    $transmission = filter_input(INPUT_POST, 'transmission', FILTER_SANITIZE_STRING) ?? '';
    $traction = filter_input(INPUT_POST, 'traction', FILTER_SANITIZE_STRING) ?? '';
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING) ?? '';
    $dimensions = filter_input(INPUT_POST, 'dimensions', FILTER_SANITIZE_STRING) ?? '';
    $trunk_capacity = filter_input(INPUT_POST, 'trunk_capacity', FILTER_SANITIZE_STRING) ?? '';
    $warranty = filter_input(INPUT_POST, 'warranty', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $previous_owners = filter_input(INPUT_POST, 'previous_owners', FILTER_SANITIZE_NUMBER_INT) ?? '';
    $service_history = filter_input(INPUT_POST, 'service_history', FILTER_SANITIZE_STRING) ?? '';
    $condition = filter_input(INPUT_POST, 'condition', FILTER_SANITIZE_STRING) ?? '';
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? '';
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING) ?? '';

    // Validate traction
    $validTractions = ['FWD', 'RWD', 'AWD', '4x4'];
    if (!in_array($traction, $validTractions)) {
        die("Erro: Valor inválido para o campo 'traction'.");
    }

    // Validate service_history
    $validServiceHistory = ['Sim', 'Não'];
    if (!in_array($service_history, $validServiceHistory)) {
        die("Erro: Valor inválido para o campo 'service_history'.");
    }

    $pdo->beginTransaction();

    try {
        // Insert car data
        $stmt = $pdo->prepare("INSERT INTO cars (brand, model, registration_year, mileage, seats, doors, fuel_type, fuel_consumption, co2_emissions, power, top_speed, acceleration, gearbox, engine_capacity, fuel_tank_capacity, transmission, traction, color, dimensions, trunk_capacity, warranty, previous_owners, service_history, `condition`, price, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$brand, $model, $registration_year, $mileage, $seats, $doors, $fuel_type, $fuel_consumption, $co2_emissions, $power, $top_speed, $acceleration, $gearbox, $engine_capacity, $fuel_tank_capacity, $transmission, $traction, $color, $dimensions, $trunk_capacity, $warranty, $previous_owners, $service_history, $condition, $price, $description]);

        $car_id = $pdo->lastInsertId();

        // Handle multiple file uploads
        $targetDir = realpath(__DIR__ . "/../assets/images/carros/");
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $maxImages = 60;
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB per file

        if (isset($_FILES["images"]) && !empty($_FILES["images"]["name"][0])) {
            $fileCount = count($_FILES["images"]["name"]);
            if ($fileCount > $maxImages) {
                throw new Exception("Erro: Número máximo de imagens ($maxImages) excedido.");
            }

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES["images"]["error"][$i] === UPLOAD_ERR_OK) {
                    // Generate unique filename to prevent overwrites
                    $fileExtension = pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION);
                    $imageFileName = uniqid('car_' . $car_id . '_', true) . '.' . $fileExtension;
                    $imagePath = $targetDir . "/" . $imageFileName;

                    // Validate file type and size
                    if (!in_array($_FILES["images"]["type"][$i], $allowedTypes)) {
                        throw new Exception("Erro: Tipo de arquivo não permitido para " . $_FILES["images"]["name"][$i] . ". Use JPEG, PNG ou GIF.");
                    }
                    if ($_FILES["images"]["size"][$i] > $maxFileSize) {
                        throw new Exception("Erro: Arquivo " . $_FILES["images"]["name"][$i] . " excede o tamanho máximo de 5MB.");
                    }

                    if (is_writable($targetDir)) {
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $imagePath)) {
                            $image_url = "assets/images/carros/" . $imageFileName;
                            $stmt = $pdo->prepare("INSERT INTO car_images (car_id, image_url) VALUES (?, ?)");
                            $stmt->execute([$car_id, $image_url]);
                        } else {
                            throw new Exception("Erro ao mover o arquivo " . $_FILES["images"]["name"][$i] . ".");
                        }
                    } else {
                        throw new Exception("O diretório de destino não é gravável.");
                    }
                } else {
                    throw new Exception("Erro no upload do arquivo " . $_FILES["images"]["name"][$i] . ": " . $_FILES["images"]["error"][$i]);
                }
            }
        } else {
            throw new Exception("Nenhuma imagem válida foi enviada.");
        }

        $pdo->commit();
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erro: " . $e->getMessage(), 3, "/Applications/XAMPP/xamppfiles/logs/php_errors.log");
        die("Erro: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Carro</title>
    <link rel="stylesheet" href="../admin/assets/css/admin.css">
</head>
<body>
    <h1>Adicionar Novo Carro</h1>
    <form action="add_car.php" method="post" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Marca" required>
        <input type="text" name="model" placeholder="Modelo" required>
        <input type="number" name="registration_year" placeholder="Ano de Registo" required>
        <input type="number" name="mileage" placeholder="Quilometragem" required>
        <input type="number" name="seats" placeholder="Número de Lugares" required>
        <input type="number" name="doors" placeholder="Número de Portas" required>
        <select name="fuel_type" required>
            <option value="" disabled selected>Selecione o tipo de combustível</option>
            <option value="Gasolina">Gasolina</option>
            <option value="GPL">GPL</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select>
        <input type="text" name="fuel_consumption" placeholder="Consumo de Combustível (L/100km)" required>
        <input type="text" name="co2_emissions" placeholder="Emissões de CO2 (g/km)" required>
        <input type="text" name="power" placeholder="Potência (cv)" required>
        <input type="text" name="top_speed" placeholder="Velocidade Máxima (km/h)" required>
        <input type="text" name="acceleration" placeholder="Aceleração (0-100 km/h)" required>
        <input type="text" name="gearbox" placeholder="Caixa de Velocidades" required>
        <input type="text" name="engine_capacity" placeholder="Capacidade do Motor (cc)" required>
        <input type="text" name="fuel_tank_capacity" placeholder="Capacidade do Tanque (L)" required>
        <select name="transmission" required>
            <option value="" disabled selected>Selecione a Transmissão</option>
            <option value="Manual">Manual</option>
            <option value="Automática">Automática</option>
            <option value="CVT">CVT</option>
        </select>
        <select name="traction" required>
            <option value="" disabled selected>Selecione o tipo de tração</option>
            <option value="FWD">Dianteira (FWD)</option>
            <option value="RWD">Traseira (RWD)</option>
            <option value="AWD">Integral (AWD)</option>
            <option value="4x4">4x4</option>
        </select>
        <input type="text" name="color" placeholder="Cor" required>
        <input type="text" name="dimensions" placeholder="Dimensões (mm)" required>
        <input type="text" name="trunk_capacity" placeholder="Capacidade do Porta-Malas (L)" required>
        <input type="number" name="warranty" placeholder="Garantia (meses)" required>
        <input type="number" name="previous_owners" placeholder="Número de Proprietários Anteriores" required>
        <select name="service_history" required>
            <option value="" disabled selected>Histórico de Serviço</option>
            <option value="Sim">Sim</option>
            <option value="Não">Não</option>
        </select>
        <select name="condition" required>
            <option value="" disabled selected>Selecione a Condição</option>
            <option value="Novo">Novo</option>
            <option value="Usado">Usado</option>
            <option value="Semi-novo">Semi-novo</option>
        </select>
        <input type="number" step="0.01" name="price" placeholder="Preço (€)" required>
        <textarea name="description" placeholder="Descrição do Carro" required></textarea>
        <input type="file" name="images[]" accept="image/*" multiple required>
        <p class="note">Pode carregar até 60 imagens (JPEG, PNG ou GIF, máx. 5MB cada).</p>
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>