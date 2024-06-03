## Идея
Идея в том, чтобы создать несколько очередей (в нашем случае 10 шт), и запустить одновременно 10 обработчиков по одному на каждую очередь.
Каждая из очередей будет содержать свои account_id, которые не пересекаются с другими очередями. 
Получилось шардирование. 
В идеале количество шардов и воркеров сделать близкое к количеству уникальных account_id, если память позволяет.

## Запустить 10 воркеров на разные очереди
```php artisan queue:work --queue=accounts_batch_0 & php artisan queue:work --queue=accounts_batch_1 & php artisan queue:work --queue=accounts_batch_2 & php artisan queue:work --queue=accounts_batch_3 & php artisan queue:work --queue=accounts_batch_4 & php artisan queue:work --queue=accounts_batch_5 & php artisan queue:work --queue=accounts_batch_6 & php artisan queue:work --queue=accounts_batch_7 & php artisan queue:work --queue=accounts_batch_8 & php artisan queue:work --queue=accounts_batch_9```

Обработчик находится в `app/Jobs/ProcessAccountJob.php`
Логирует все свои отработанные элементы в `storage/logs/laravel.log`

## Запустить тестовую команду, чтобы заполнить очереди хаотичными данными
```php artisan app:fill-queue --count=10000```

```app/Console/Commands/FillQueue.php```