TYPE=VIEW
query=select `insentif`.`penjualan_detail`.`idpenjualan` AS `idpenjualan`,`insentif`.`penjualan`.`tglpenjualan` AS `tglpenjualan`,`insentif`.`penjualan_detail`.`idbarang` AS `idbarang`,`insentif`.`barang`.`namabarang` AS `namabarang`,`insentif`.`barang`.`jenis` AS `jenis`,`insentif`.`barang`.`satuan` AS `satuan`,`insentif`.`penjualan_detail`.`qty` AS `qty`,`insentif`.`penjualan_detail`.`hargajual` AS `hargajual`,`insentif`.`penjualan_detail`.`totalharga` AS `totalharga` from ((`insentif`.`penjualan_detail` join `insentif`.`penjualan` on(`insentif`.`penjualan_detail`.`idpenjualan` = `insentif`.`penjualan`.`idpenjualan`)) join `insentif`.`barang` on(`insentif`.`penjualan_detail`.`idbarang` = `insentif`.`barang`.`idbarang`))
md5=a44518292ce0e25bc612da8736000a3a
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2024-06-16 13:52:33
create-version=2
source=select `penjualan_detail`.`idpenjualan` AS `idpenjualan`,`penjualan`.`tglpenjualan` AS `tglpenjualan`,`penjualan_detail`.`idbarang` AS `idbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`jenis` AS `jenis`,`barang`.`satuan` AS `satuan`,`penjualan_detail`.`qty` AS `qty`,`penjualan_detail`.`hargajual` AS `hargajual`,`penjualan_detail`.`totalharga` AS `totalharga` from ((`penjualan_detail` join `penjualan` on(`penjualan_detail`.`idpenjualan` = `penjualan`.`idpenjualan`)) join `barang` on(`penjualan_detail`.`idbarang` = `barang`.`idbarang`))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `insentif`.`penjualan_detail`.`idpenjualan` AS `idpenjualan`,`insentif`.`penjualan`.`tglpenjualan` AS `tglpenjualan`,`insentif`.`penjualan_detail`.`idbarang` AS `idbarang`,`insentif`.`barang`.`namabarang` AS `namabarang`,`insentif`.`barang`.`jenis` AS `jenis`,`insentif`.`barang`.`satuan` AS `satuan`,`insentif`.`penjualan_detail`.`qty` AS `qty`,`insentif`.`penjualan_detail`.`hargajual` AS `hargajual`,`insentif`.`penjualan_detail`.`totalharga` AS `totalharga` from ((`insentif`.`penjualan_detail` join `insentif`.`penjualan` on(`insentif`.`penjualan_detail`.`idpenjualan` = `insentif`.`penjualan`.`idpenjualan`)) join `insentif`.`barang` on(`insentif`.`penjualan_detail`.`idbarang` = `insentif`.`barang`.`idbarang`))
mariadb-version=100411
