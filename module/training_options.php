<div class="form-group">
  <div class="form-check">
    <label class="form-check-label">
    <input checked id = "all_words" class="form-check-input" type="checkbox"> Выбирать варианты ответы из всех слов </label>
  </div>
</div>

<div onclick="start_training(this, 'multichoice', 'ru-he')" class="card trainig-option text-white bg-primary mb-3">
    <div class="card-header bg-primary">Поиск перевода ru-he</div>
    <div class="card-body p-2">
        <p class="card-text">Выбор перевода из списка</p>
    </div>
</div>
<div onclick="start_training(this, 'multichoice', 'he-ru')" class="card trainig-option text-white bg-info mb-3">
    <div class="card-header bg-info">Поиск перевода he-ru</div>
    <div class="card-body p-2">
        <p class="card-text">Выбор перевода из списка</p>
    </div>
</div>
<div onclick="start_training(this, 'spelling', 'ru-he')" class="card trainig-option text-white bg-primary mb-3">
    <div class="card-header bg-primary">Перевод ru-he</div>
    <div class="card-body p-2">
        <p class="card-text">Ввод перевода с клавиатуры</p>
    </div>
</div>
<div onclick="start_training(this, 'spelling', 'he-ru')" class="card trainig-option text-white bg-info mb-3">
    <div class="card-header bg-info">Перевод he-ru</div>
    <div class="card-body p-2">
        <p class="card-text">Ввод перевода с клавиатуры</p>
    </div>
</div>
<div onclick="start_training(this, 'plural', 'he-he')" class="card trainig-option text-white bg-info mb-3">
    <div class="card-header bg-info">Определение мн.ч. существительного</div>
    <div class="card-body p-2">
        <p class="card-text">Определение мн.ч. существительного</p>
    </div>
</div>
<div onclick="start_training(this, 'infinitive', 'he-he')" class="card trainig-option text-white bg-success mb-3">
    <div class="card-header bg-success">Определение инфинитива</div>
    <div class="card-body p-2">
        <p class="card-text">Определение инфинитива глаголы</p>
    </div>
</div>
<div onclick="start_training(this, 'prepositions', 'he-he')" class="card trainig-option text-white bg-info mb-3">
    <div class="card-header bg-info">Определение предлога</div>
    <div class="card-body p-2">
        <p class="card-text">Определение предлогов у глаголов</p>
    </div>
</div>
<div id="choose-option" class="alert alert-dismissible fade show" role="alert"></div>