User
1. username
2. phone_number
3. roles

Kategori Produk
1. nama

Produk
1. nama
2. harga
3. deskripsi
4. tags
5. Kategori Produk

Galeri Produk
1. Produk
2. url

Transaksi : checkout menggunakan API
1. User
2. alamat
3. metode bayar
4. total harga
5. total pengiriman
6. status

Detail Transaksi
1. User
2. Produk
3. Transaksi
4. kuantitas

=========Tabel==========

product_categories
- id:bigint
- name:varchar
- created_at NULL
- updated_at NULL
- deleted_at NULL

products
- id:bigint
- name:varchar
- price:float
- description:longtext
- tags:varchar
- categories_id:bigint (fk)
- created_at NULL
- updated_at NULL
- deleted_at NULL

product_galleries
- id:bigint
- products_id:bigint (fk)
- url:varchar
- created_at NULL
- updated_at NULL
- deleted_at NULL

transactions
- id:bigint
- users_id:bigint (fk)
- address:text NULL
- payment:varchar [Manual]
- total_price:float
- shipping_price:float
- status:varchar [Default:Pending]
- created_at NULL
- updated_at NULL
- deleted_at NULL

transaction_details
- id:bigint
- users_id:bigint
- products_id:bigint
- transactions_id:bigint
- quantity:bigint
- created_at NULL
- updated_at NULL
- deleted_at NULL

users
- id:bigint
- username:varchar
- phone_number:varchar
- roles:varchar
