
SELECT mg01.*, mg02.mk01_id, mg02.mg01_id, mg02.nilgj, 
                CASE WHEN mg01.jntgh = 'Bulan' 
                THEN 
                        COALESCE(period_diff(date_format(DATE_ADD('2016-07-31 00:00:00', INTERVAL 1 MONTH), '%Y%m'), date_format('2016-07-31 00:00:00', '%Y%m')), 0)
                ELSE 
                        CASE WHEN mg01.jntgh = 'Hari' 
                        THEN 
                                COALESCE((SELECT                                  
                                SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.goHome, '%H:%i'), DATE_FORMAT(tabel_terluar.goWork, '%H:%i'))) as integer),0)) + SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.breakIn, '%H:%i'), DATE_FORMAT(tabel_terluar.breakOut, '%H:%i'))) as integer),3600)) 
                                FROM ( 
                                    SELECT DISTINCT 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 0 ) as goWork, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 2 ) as breakOut, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 3 ) as breakIn, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 1 ) as goHome,
                                        mk01_id
                                    FROM ta02 as tabel_luar 
                                        WHERE MONTH(tabel_luar.tglmsk) = MONTH('2016-07-31 00:00:00') AND YEAR(tabel_luar.tglmsk) = YEAR('2016-07-31 00:00:00')
                                    ) as tabel_terluar
                                    WHERE mk01_id = karyawan.idkar
                                GROUP BY mk01_id), 0)
                        ELSE 
                COALESCE((SELECT 
                COALESCE((SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.overWorkOut, '%H:%i'), DATE_FORMAT(tabel_terluar.overWorkIn, '%H:%i'))) as integer),0))), 0) as nilai
                FROM ( 
                    SELECT DISTINCT         
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 4 ) as overWorkIn,
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 5 ) as overWorkOut,
                        mk01_id
                    FROM ta02 as tabel_luar 
                        WHERE MONTH(tabel_luar.tglmsk) = MONTH('2016-07-31 00:00:00') AND YEAR(tabel_luar.tglmsk) = YEAR('2016-07-31 00:00:00')
                    ) as tabel_terluar
                    WHERE mk01_id = karyawan.idkar
                GROUP BY mk01_id),0)
                        END 
                END as jmtgh,
                CASE WHEN mg01.jntgh = 'Hari' THEN
                    (SELECT COUNT(*) FROM ta02 WHERE ta02.abscd = 0 AND ta02.mk01_id = karyawan.idkar AND MONTH(ta02.tglmsk) = MONTH('2016-07-31 00:00:00'))
                        ELSE
                            CASE WHEN mg01.jntgh = 'Bulan' THEN
                                period_diff(date_format(DATE_ADD('2016-07-31 00:00:00', INTERVAL 1 MONTH), '%Y%m'), date_format('2016-07-31 00:00:00', '%Y%m'))
                            ELSE
                                0 
                            END
                        END
                    as hari
                FROM mg02 
                INNER JOIN mg01 ON mg01.idgj = mg02.mg01_id 
                INNER JOIN mk01 as karyawan ON karyawan.idkar = mg02.mk01_id
                WHERE karyawan.idkar = 5;








