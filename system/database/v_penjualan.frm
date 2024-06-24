TYPE=VIEW
query=select `insentif`.`penjualan`.`idpenjualan` AS `idpenjualan`,`insentif`.`penjualan`.`tglpenjualan` AS `tglpenjualan`,`insentif`.`penjualan`.`idkonsumen` AS `idkonsumen`,`insentif`.`konsumen`.`namakonsumen` AS `namakonsumen`,`insentif`.`konsumen`.`notelp` AS `notelp`,`insentif`.`konsumen`.`email` AS `email`,`insentif`.`penjualan`.`keterangan` AS `keterangan`,(select sum(`insentif`.`penjualan_detail`.`totalharga`) from `insentif`.`penjualan_detail` where `insentif`.`penjualan_detail`.`idpenjualan` = `insentif`.`penjualan`.`idpenjualan`) AS `totalharga`,`insentif`.`penjualan`.`tglinsert` AS `tglinsert`,`insentif`.`penjualan`.`tglupdate` AS `tglupdate`,`insentif`.`penjualan`.`idkaryawan` AS `idkaryawan`,`insentif`.`karyawan`.`namakaryawan` AS `namakaryawan`,`insentif`.`karyawan`.`jabatan` AS `jabatan` from ((`insentif`.`penjualan` join `insentif`.`konsumen` on(`insentif`.`penjualan`.`idkonsumen` = `insentif`.`konsumen`.`idkonsumen`)) join `insentif`.`karyawan` on(`insentif`.`penjualan`.`idkaryawan` = `insentif`.`karyawan`.`idkaryawan`))
md5=f811a55cca26c24444ba7d8854c563d0
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2024-06-16 13:52:33
create-version=2
source=select `penjualan`.`idpenjualan` AS `idpenjualan`,`penjualan`.`tglpenjualan` AS `tglpenjualan`,`penjualan`.`idkonsumen` AS `idkonsumen`,`konsumen`.`namakonsumen` AS `namakonsumen`,`konsumen`.`notelp` AS `notelp`,`konsumen`.`email` AS `email`,`penjualan`.`keterangan` AS `keterangan`,(select sum(`penjualan_detail`.`totalharga`) from `penjualan_detail` where `penjualan_detail`.`idpenjualan` = `penjualan`.`idpenjualan`) AS `totalharga`,`penjualan`.`tglinsert` AS `tglinsert`,`penjualan`.`tglupdate` AS `tglupdate`,`penjualan`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`jabatan` AS `jabatan` from ((`penjualan` join `konsumen` on(`penjualan`.`idkonsumen` = `konsumen`.`idkonsumen`)) join `karyawan` on(`penjualan`.`idkaryawan` = `karyawan`.`idkaryawan`))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `insentif`.`penjualan`.`idpenjualan` AS `idpenjualan`,`insentif`.`penjualan`.`tglpenjualan` AS `tglpenjualan`,`insentif`.`penjualan`.`idkonsumen` AS `idkonsumen`,`insentif`.`konsumen`.`namakonsumen` AS `namakonsumen`,`insentif`.`konsumen`.`notelp` AS `notelp`,`insentif`.`konsumen`.`email` AS `email`,`insentif`.`penjualan`.`keterangan` AS `keterangan`,(select sum(`insentif`.`penjualan_detail`.`totalharga`) from `insentif`.`penjualan_detail` where `insentif`.`penjualan_detail`.`idpenjualan` = `insentif`.`penjualan`.`idpenjualan`) AS `totalharga`,`insentif`.`penjualan`.`tglinsert` AS `tglinsert`,`insentif`.`penjualan`.`tglupdate` AS `tglupdate`,`insentif`.`penjualan`.`idkaryawan` AS `idkaryawan`,`insentif`.`karyawan`.`namakaryawan` AS `namakaryawan`,`insentif`.`karyawan`.`jabatan` AS `jabatan` from ((`insentif`.`penjualan` join `insentif`.`konsumen` on(`insentif`.`penjualan`.`idkonsumen` = `insentif`.`konsumen`.`idkonsumen`)) join `insentif`.`karyawan` on(`insentif`.`penjualan`.`idkaryawan` = `insentif`.`karyawan`.`idkaryawan`))
mariadb-version=100411
