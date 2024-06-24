TYPE=VIEW
query=select `insentif`.`insentif`.`idinsentif` AS `idinsentif`,`insentif`.`insentif`.`target` AS `target`,`insentif`.`insentif`.`besarbonus` AS `besarbonus`,`insentif`.`insentif`.`keterangan` AS `keterangan`,`insentif`.`insentif`.`statusaktif` AS `statusaktif`,`insentif`.`insentif`.`tginsert` AS `tginsert`,`insentif`.`insentif`.`tglupdate` AS `tglupdate`,`insentif`.`insentif`.`idkaryawan` AS `idkaryawan`,`insentif`.`karyawan`.`namakaryawan` AS `namakaryawan`,`insentif`.`karyawan`.`jabatan` AS `jabatan` from (`insentif`.`insentif` join `insentif`.`karyawan` on(`insentif`.`insentif`.`idkaryawan` = `insentif`.`karyawan`.`idkaryawan`))
md5=49511d612eb57fa8207424b7bc3b022f
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2024-06-16 13:52:32
create-version=2
source=select `insentif`.`idinsentif` AS `idinsentif`,`insentif`.`target` AS `target`,`insentif`.`besarbonus` AS `besarbonus`,`insentif`.`keterangan` AS `keterangan`,`insentif`.`statusaktif` AS `statusaktif`,`insentif`.`tginsert` AS `tginsert`,`insentif`.`tglupdate` AS `tglupdate`,`insentif`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`jabatan` AS `jabatan` from (`insentif` join `karyawan` on(`insentif`.`idkaryawan` = `karyawan`.`idkaryawan`))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `insentif`.`insentif`.`idinsentif` AS `idinsentif`,`insentif`.`insentif`.`target` AS `target`,`insentif`.`insentif`.`besarbonus` AS `besarbonus`,`insentif`.`insentif`.`keterangan` AS `keterangan`,`insentif`.`insentif`.`statusaktif` AS `statusaktif`,`insentif`.`insentif`.`tginsert` AS `tginsert`,`insentif`.`insentif`.`tglupdate` AS `tglupdate`,`insentif`.`insentif`.`idkaryawan` AS `idkaryawan`,`insentif`.`karyawan`.`namakaryawan` AS `namakaryawan`,`insentif`.`karyawan`.`jabatan` AS `jabatan` from (`insentif`.`insentif` join `insentif`.`karyawan` on(`insentif`.`insentif`.`idkaryawan` = `insentif`.`karyawan`.`idkaryawan`))
mariadb-version=100411
