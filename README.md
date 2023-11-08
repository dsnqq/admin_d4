# Админ-панель для d4.by (© Daniil 2023) 

- Admin_d4
- Api opencart 2.3
- Node v16.16.0
- Vue-router 3.6.5
- Vuex 3.6.2"
- Тип MVVM

## Базовая установка проекта
- npm install // Подключаем пакеты
- npm run serve // Запускаем сборку
- npm run build // Собрать сборку для заливки на FTP
- npm run lint // Запустить линтер

## Основные разделы проекта
- Главная панель
- Мои запчасти
- Архив Запчастей
- Добавить запчасть
- История пользователей
- Авто в разборе
- Мои шины
- Архив Шин
- Добавить шину
- Статистика шин
- Статистика З/Ч

## Карта Vuex
- Главная панель.        @route: dashboardAdmin
- Мои запчасти.          @route: autoParts
- Архив Запчастей.       @route: autoPartsArchive
- Заказы.                @route: orderSale
- История пользователей. @route: historyUsers
- Авто в разборе.        @route: carAdmin
- Мои шины.              @route: autoTire
- Архив Шин.             @route: tireArchive
- Статистика шин.        @route: tireStatistics
- Статистика З/Ч.        @route: sparePartsStatistics
