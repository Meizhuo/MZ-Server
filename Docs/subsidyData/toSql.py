# -*- coding:utf-8 -*-

import os

sql_file = 'subsidy.sql'

def get_data(file_name):
    res = {}
    with open(file_name, mode='r') as f:
        res['certificate_type'] = f.readline()
        res['kind'] = f.readline()
        res['level'] = f.readline()
        res['money'] = f.readline()
        res['title'] = f.readline()
    return res

def deal_with(file_name):
    res =  get_data(file_name)
    with open(sql_file, 'a+') as f :
        content = "INSERT INTO `mz_subsidy_standary` (`certificate_type`, `kind`, `level`, `money`, `series`, `title`) VALUES('{certificate_type}', '{kind}', '{level}', '{money}', '{series}', '{title}');\r\n".\
                format(certificate_type=res['certificate_type'],kind=res['kind'] ,level=res['level'],money=res['money'],series='' ,title=res['title'])
       
        
        for subtitle in res['title'].split('、'):
           content = "INSERT INTO `mz_subsidy_standary` (`certificate_type`, `kind`, `level`, `money`, `series`, `title`) VALUES('{certificate_type}', '{kind}', '{level}', '{money}', '{series}', '{title}');\r\n".\
                format(certificate_type=res['certificate_type'],kind=res['kind'] ,level=res['level'],money=res['money'],series='' ,title=subtitle)
           f.write(content) 


def main():

    if os.path.exists(sql_file):
        os.remove(sql_file)

    for x in range(1,20):
        deal_with('data%d.txt'% x)
        # print 'data%d.txt'% x

if __name__  == '__main__':
    main()
