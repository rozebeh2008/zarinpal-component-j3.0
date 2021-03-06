DROP TABLE IF EXISTS #__easypayzarinpal;
CREATE TABLE IF NOT EXISTS #__easypayzarinpal (
  `id` int(11) unsigned NOT NULL auto_increment,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL default '0',
  `mobile` varchar(11) NOT NULL default '0',
  `mellicode` varchar(10) NOT NULL default '0',
  `state` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `address` varchar(255) default NULL,
  `postcode` varchar(10) NOT NULL default '0',
  `description` text,
  `attachment` varchar(255) NOT NULL default '0',
  `cost` varchar(20) NOT NULL default '0',
  `orderid` int(10) NOT NULL default '0',
  `salerefid` varchar(12) NOT NULL default '0',
  `refid` varchar(16) NOT NULL default '0',
  `paydate` datetime NOT NULL default '0000-00-00 00:00:00',
  `msgid` int(11) NOT NULL default '500',
  `sattel` int(3) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS #__easypayzarinpal_bankmsg;
CREATE TABLE IF NOT EXISTS #__easypayzarinpal_bankmsg (
  `id` int(11) unsigned NOT NULL auto_increment,
  `code` varchar(3) NOT NULL,
  `msg` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;
INSERT INTO `#__easypayzarinpal_bankmsg` (`id`, `code`, `msg`) VALUES
(1, '500', 'کاربر به صفحه زرین پال رفته ولي هنوز بر نگشته است'),
(2, '100', 'تراکنش با موفقيت انجام شد.'),
(3, '11', 'شماره کارت نامعتبر است'),
(4, '12', 'موجودي کافي نيست'),
(5, '13', 'رمز نادرست است'),
(6, '14', 'تعداد دفعات وارد کردن رمز بيش از حد مجاز است'),
(7, '15', 'کارت نامعتبر است'),
(8, '17', 'کاربر از انجام تراکنش منصرف شده است'),
(9, '18', 'تاريخ انقضاي کارت گذشته است'),
(10, '111', 'صادر کننده کارت نامعتبر است'),
(11, '112', 'خطاي سوئيچ صادر کننده کارت'),
(12, '113', 'پاسخي از صادر کننده کارت دريافت نشد'),
(13, '114', 'دارنده کارت مجاز به انجام اين تراکنش نيست'),
(14, '21', 'پذيرنده نامعتبر است'),
(15, '22', 'ترمينال مجوز ارايه سرويس درخواستي را ندارد'),
(16, '23', 'خطاي امنيتي رخ داده است'),
(17, '24', 'اطلاعات کاربري پذيرنده نامعتبر است'),
(18, '25', 'مبلغ نامعتبر است'),
(19, '31', 'پاسخ نامعتبر است'),
(20, '32', 'فرمت اطلاعات وارد شده صحيح نمي باشد'),
(21, '33', 'حساب نامعتبر است'),
(22, '34', 'خطاي سيستمي'),
(23, '35', 'تاريخ نامعتبر است'),
(24, '41', 'شماره درخواست تکراري است'),
(25, '42', 'تراکنش Sale يافت نشد'),
(26, '43', 'قبلا درخواست Verify داده شده است'),
(27, '44', 'درخواست Verify يافت نشد'),
(28, '45', 'تراکنش Settle شده است'),
(29, '46', 'تراکنش Settle نشده است'),
(30, '47', 'تراکنش Settle يافت نشد'),
(31, '48', 'تراکنش Reverse شده است'),
(32, '49', 'تراکنش Refund يافت نشد'),
(33, '412', 'شناسه قبض نادرست است'),
(34, '413', 'شناسه پرداخت نادرست است'),
(35, '414', 'سازمان صادر کننده قبض نامعتبر است'),
(36, '415', 'زمان جلسه کاري به پايان رسيده است'),
(37, '416', 'خطا در ثبت اطلاعات'),
(38, '417', 'شناسه پرداخت کننده نامعتبر است'),
(39, '418', 'اشکال در تعريف اطلاعات مشتري'),
(40, '419', 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است'),
(41, '421', 'IP نامعتبر است'),
(42, '51', 'تراکنش تکراري است'),
(43, '52', 'سرويس درخواستي موجود نمي باشد'),
(44, '54', 'تراکنش مرجع موجود نيست'),
(45, '55', 'تراکنش نامعتبر است'),
(46, '61', 'خطا در واريز');