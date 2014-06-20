/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : intranet

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-06-20 16:04:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(128) NOT NULL,
  `iso_code_3` varchar(128) NOT NULL,
  `postcode_required` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'Afghanistan', 'AF', 'AFG', '1', '1');
INSERT INTO `country` VALUES ('2', 'Albania', 'AL', 'ALB', '0', '1');
INSERT INTO `country` VALUES ('3', 'Algeria', 'DZ', 'DZA', '1', '1');
INSERT INTO `country` VALUES ('4', 'American Samoa', 'AS', 'ASM', '0', '1');
INSERT INTO `country` VALUES ('5', 'Andorra', 'AD', 'AND', '0', '1');
INSERT INTO `country` VALUES ('6', 'Angola', 'AO', 'AGO', '0', '1');
INSERT INTO `country` VALUES ('7', 'Anguilla', 'AI', 'AIA', '0', '1');
INSERT INTO `country` VALUES ('8', 'Antarctica', 'AQ', 'ATA', '1', '1');
INSERT INTO `country` VALUES ('9', 'Antigua and Barbuda', 'AG', 'ATG', '0', '1');
INSERT INTO `country` VALUES ('10', 'Argentina', 'AR', 'ARG', '1', '1');
INSERT INTO `country` VALUES ('11', 'Armenia', 'AM', 'ARM', '1', '1');
INSERT INTO `country` VALUES ('12', 'Aruba', 'AW', 'ABW', '0', '1');
INSERT INTO `country` VALUES ('13', 'Australia', 'AU', 'AUS', '1', '1');
INSERT INTO `country` VALUES ('14', 'Austria', 'AT', 'AUT', '1', '1');
INSERT INTO `country` VALUES ('15', 'Azerbaijan', 'AZ', 'AZE', '1', '1');
INSERT INTO `country` VALUES ('16', 'Bahamas', 'BS', 'BHS', '0', '1');
INSERT INTO `country` VALUES ('17', 'Bahrain', 'BH', 'BHR', '0', '1');
INSERT INTO `country` VALUES ('18', 'Bangladesh', 'BD', 'BGD', '1', '1');
INSERT INTO `country` VALUES ('19', 'Barbados', 'BB', 'BRB', '0', '1');
INSERT INTO `country` VALUES ('20', 'Belarus', 'BY', 'BLR', '1', '1');
INSERT INTO `country` VALUES ('21', 'Belgium', 'BE', 'BEL', '1', '1');
INSERT INTO `country` VALUES ('22', 'Belize', 'BZ', 'BLZ', '0', '1');
INSERT INTO `country` VALUES ('23', 'Benin', 'BJ', 'BEN', '0', '1');
INSERT INTO `country` VALUES ('24', 'Bermuda', 'BM', 'BMU', '0', '1');
INSERT INTO `country` VALUES ('25', 'Bhutan', 'BT', 'BTN', '0', '1');
INSERT INTO `country` VALUES ('26', 'Bolivia', 'BO', 'BOL', '0', '1');
INSERT INTO `country` VALUES ('27', 'Bosnia and Herzegowina', 'BA', 'BIH', '1', '1');
INSERT INTO `country` VALUES ('28', 'Botswana', 'BW', 'BWA', '0', '1');
INSERT INTO `country` VALUES ('29', 'Bouvet Island', 'BV', 'BVT', '1', '1');
INSERT INTO `country` VALUES ('30', 'Brazil', 'BR', 'BRA', '1', '1');
INSERT INTO `country` VALUES ('31', 'British Indian Ocean Territory', 'IO', 'IOT', '1', '1');
INSERT INTO `country` VALUES ('32', 'Brunei Darussalam', 'BN', 'BRN', '0', '1');
INSERT INTO `country` VALUES ('33', 'Bulgaria', 'BG', 'BGR', '1', '1');
INSERT INTO `country` VALUES ('34', 'Burkina Faso', 'BF', 'BFA', '0', '1');
INSERT INTO `country` VALUES ('35', 'Burundi', 'BI', 'BDI', '0', '1');
INSERT INTO `country` VALUES ('36', 'Cambodia', 'KH', 'KHM', '0', '1');
INSERT INTO `country` VALUES ('37', 'Cameroon', 'CM', 'CMR', '0', '1');
INSERT INTO `country` VALUES ('38', 'Canada', 'CA', 'CAN', '1', '1');
INSERT INTO `country` VALUES ('39', 'Cape Verde', 'CV', 'CPV', '0', '1');
INSERT INTO `country` VALUES ('40', 'Cayman Islands', 'KY', 'CYM', '0', '1');
INSERT INTO `country` VALUES ('41', 'Central African Republic', 'CF', 'CAF', '0', '1');
INSERT INTO `country` VALUES ('42', 'Chad', 'TD', 'TCD', '0', '1');
INSERT INTO `country` VALUES ('43', 'Chile', 'CL', 'CHL', '0', '1');
INSERT INTO `country` VALUES ('44', 'China', 'CN', 'CHN', '1', '1');
INSERT INTO `country` VALUES ('45', 'Christmas Island', 'CX', 'CXR', '1', '1');
INSERT INTO `country` VALUES ('46', 'Cocos (Keeling) Islands', 'CC', 'CCK', '1', '1');
INSERT INTO `country` VALUES ('47', 'Colombia', 'CO', 'COL', '0', '1');
INSERT INTO `country` VALUES ('48', 'Comoros', 'KM', 'COM', '1', '1');
INSERT INTO `country` VALUES ('49', 'Congo', 'CG', 'COG', '0', '1');
INSERT INTO `country` VALUES ('50', 'Cook Islands', 'CK', 'COK', '0', '1');
INSERT INTO `country` VALUES ('51', 'Costa Rica', 'CR', 'CRI', '0', '1');
INSERT INTO `country` VALUES ('52', 'Cote D\'Ivoire', 'CI', 'CIV', '1', '1');
INSERT INTO `country` VALUES ('53', 'Croatia', 'HR', 'HRV', '1', '1');
INSERT INTO `country` VALUES ('54', 'Cuba', 'CU', 'CUB', '1', '1');
INSERT INTO `country` VALUES ('55', 'Cyprus', 'CY', 'CYP', '1', '1');
INSERT INTO `country` VALUES ('56', 'Czech Republic', 'CZ', 'CZE', '1', '1');
INSERT INTO `country` VALUES ('57', 'Denmark', 'DK', 'DNK', '1', '1');
INSERT INTO `country` VALUES ('58', 'Djibouti', 'DJ', 'DJI', '0', '1');
INSERT INTO `country` VALUES ('59', 'Dominica', 'DM', 'DMA', '0', '1');
INSERT INTO `country` VALUES ('60', 'Dominican Republic', 'DO', 'DOM', '0', '1');
INSERT INTO `country` VALUES ('61', 'East Timor', 'TP', 'TMP', '1', '1');
INSERT INTO `country` VALUES ('62', 'Ecuador', 'EC', 'ECU', '0', '1');
INSERT INTO `country` VALUES ('63', 'Egypt', 'EG', 'EGY', '0', '1');
INSERT INTO `country` VALUES ('64', 'El Salvador', 'SV', 'SLV', '0', '1');
INSERT INTO `country` VALUES ('65', 'Equatorial Guinea', 'GQ', 'GNQ', '0', '1');
INSERT INTO `country` VALUES ('66', 'Eritrea', 'ER', 'ERI', '0', '1');
INSERT INTO `country` VALUES ('67', 'Estonia', 'EE', 'EST', '1', '1');
INSERT INTO `country` VALUES ('68', 'Ethiopia', 'ET', 'ETH', '0', '1');
INSERT INTO `country` VALUES ('69', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '1', '1');
INSERT INTO `country` VALUES ('70', 'Faroe Islands', 'FO', 'FRO', '1', '1');
INSERT INTO `country` VALUES ('71', 'Fiji', 'FJ', 'FJI', '0', '1');
INSERT INTO `country` VALUES ('72', 'Finland', 'FI', 'FIN', '1', '1');
INSERT INTO `country` VALUES ('73', 'France', 'FR', 'FRA', '1', '1');
INSERT INTO `country` VALUES ('74', 'France, Metropolitan', 'FX', 'FXX', '1', '1');
INSERT INTO `country` VALUES ('75', 'French Guiana', 'GF', 'GUF', '0', '1');
INSERT INTO `country` VALUES ('76', 'French Polynesia', 'PF', 'PYF', '0', '1');
INSERT INTO `country` VALUES ('77', 'French Southern Territories', 'TF', 'ATF', '1', '1');
INSERT INTO `country` VALUES ('78', 'Gabon', 'GA', 'GAB', '0', '1');
INSERT INTO `country` VALUES ('79', 'Gambia', 'GM', 'GMB', '0', '1');
INSERT INTO `country` VALUES ('80', 'Georgia', 'GE', 'GEO', '1', '1');
INSERT INTO `country` VALUES ('81', 'Germany', 'DE', 'DEU', '1', '1');
INSERT INTO `country` VALUES ('82', 'Ghana', 'GH', 'GHA', '0', '1');
INSERT INTO `country` VALUES ('83', 'Gibraltar', 'GI', 'GIB', '0', '1');
INSERT INTO `country` VALUES ('84', 'Greece', 'GR', 'GRC', '1', '1');
INSERT INTO `country` VALUES ('85', 'Greenland', 'GL', 'GRL', '1', '1');
INSERT INTO `country` VALUES ('86', 'Grenada', 'GD', 'GRD', '0', '1');
INSERT INTO `country` VALUES ('87', 'Guadeloupe', 'GP', 'GLP', '0', '1');
INSERT INTO `country` VALUES ('88', 'Guam', 'GU', 'GUM', '0', '1');
INSERT INTO `country` VALUES ('89', 'Guatemala', 'GT', 'GTM', '0', '1');
INSERT INTO `country` VALUES ('90', 'Guinea', 'GN', 'GIN', '0', '1');
INSERT INTO `country` VALUES ('91', 'Guinea-bissau', 'GW', 'GNB', '0', '1');
INSERT INTO `country` VALUES ('92', 'Guyana', 'GY', 'GUY', '0', '1');
INSERT INTO `country` VALUES ('93', 'Haiti', 'HT', 'HTI', '0', '1');
INSERT INTO `country` VALUES ('94', 'Heard and Mc Donald Islands', 'HM', 'HMD', '1', '1');
INSERT INTO `country` VALUES ('95', 'Honduras', 'HN', 'HND', '0', '1');
INSERT INTO `country` VALUES ('96', 'Hong Kong', 'HK', 'HKG', '0', '1');
INSERT INTO `country` VALUES ('97', 'Hungary', 'HU', 'HUN', '1', '1');
INSERT INTO `country` VALUES ('98', 'Iceland', 'IS', 'ISL', '1', '1');
INSERT INTO `country` VALUES ('99', 'India', 'IN', 'IND', '1', '1');
INSERT INTO `country` VALUES ('100', 'Indonesia', 'ID', 'IDN', '1', '1');
INSERT INTO `country` VALUES ('101', 'Iran (Islamic Republic of)', 'IR', 'IRN', '1', '1');
INSERT INTO `country` VALUES ('102', 'Iraq', 'IQ', 'IRQ', '0', '1');
INSERT INTO `country` VALUES ('103', 'Ireland', 'IE', 'IRL', '0', '1');
INSERT INTO `country` VALUES ('104', 'Israel', 'IL', 'ISR', '1', '1');
INSERT INTO `country` VALUES ('105', 'Italy', 'IT', 'ITA', '1', '1');
INSERT INTO `country` VALUES ('106', 'Jamaica', 'JM', 'JAM', '0', '1');
INSERT INTO `country` VALUES ('107', 'Japan', 'JP', 'JPN', '1', '1');
INSERT INTO `country` VALUES ('108', 'Jordan', 'JO', 'JOR', '0', '1');
INSERT INTO `country` VALUES ('109', 'Kazakhstan', 'KZ', 'KAZ', '1', '1');
INSERT INTO `country` VALUES ('110', 'Kenya', 'KE', 'KEN', '0', '1');
INSERT INTO `country` VALUES ('111', 'Kiribati', 'KI', 'KIR', '0', '1');
INSERT INTO `country` VALUES ('112', 'North Korea', 'KP', 'PRK', '1', '1');
INSERT INTO `country` VALUES ('113', 'Korea, Republic of', 'KR', 'KOR', '1', '1');
INSERT INTO `country` VALUES ('114', 'Kuwait', 'KW', 'KWT', '0', '1');
INSERT INTO `country` VALUES ('115', 'Kyrgyzstan', 'KG', 'KGZ', '1', '1');
INSERT INTO `country` VALUES ('116', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '0', '1');
INSERT INTO `country` VALUES ('117', 'Latvia', 'LV', 'LVA', '1', '1');
INSERT INTO `country` VALUES ('118', 'Lebanon', 'LB', 'LBN', '0', '1');
INSERT INTO `country` VALUES ('119', 'Lesotho', 'LS', 'LSO', '0', '1');
INSERT INTO `country` VALUES ('120', 'Liberia', 'LR', 'LBR', '0', '1');
INSERT INTO `country` VALUES ('121', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '1', '1');
INSERT INTO `country` VALUES ('122', 'Liechtenstein', 'LI', 'LIE', '1', '1');
INSERT INTO `country` VALUES ('123', 'Lithuania', 'LT', 'LTU', '1', '1');
INSERT INTO `country` VALUES ('124', 'Luxembourg', 'LU', 'LUX', '1', '1');
INSERT INTO `country` VALUES ('125', 'Macau', 'MO', 'MAC', '0', '1');
INSERT INTO `country` VALUES ('126', 'Macedonia', 'MK', 'MKD', '1', '1');
INSERT INTO `country` VALUES ('127', 'Madagascar', 'MG', 'MDG', '0', '1');
INSERT INTO `country` VALUES ('128', 'Malawi', 'MW', 'MWI', '1', '1');
INSERT INTO `country` VALUES ('129', 'Malaysia', 'MY', 'MYS', '1', '1');
INSERT INTO `country` VALUES ('130', 'Maldives', 'MV', 'MDV', '0', '1');
INSERT INTO `country` VALUES ('131', 'Mali', 'ML', 'MLI', '0', '1');
INSERT INTO `country` VALUES ('132', 'Malta', 'MT', 'MLT', '0', '1');
INSERT INTO `country` VALUES ('133', 'Marshall Islands', 'MH', 'MHL', '1', '1');
INSERT INTO `country` VALUES ('134', 'Martinique', 'MQ', 'MTQ', '1', '1');
INSERT INTO `country` VALUES ('135', 'Mauritania', 'MR', 'MRT', '0', '1');
INSERT INTO `country` VALUES ('136', 'Mauritius', 'MU', 'MUS', '0', '1');
INSERT INTO `country` VALUES ('137', 'Mayotte', 'YT', 'MYT', '1', '1');
INSERT INTO `country` VALUES ('138', 'Mexico', 'MX', 'MEX', '1', '1');
INSERT INTO `country` VALUES ('139', 'Micronesia, Federated States of', 'FM', 'FSM', '1', '1');
INSERT INTO `country` VALUES ('140', 'Moldova, Republic of', 'MD', 'MDA', '1', '1');
INSERT INTO `country` VALUES ('141', 'Monaco', 'MC', 'MCO', '1', '1');
INSERT INTO `country` VALUES ('142', 'Mongolia', 'MN', 'MNG', '1', '1');
INSERT INTO `country` VALUES ('143', 'Montserrat', 'MS', 'MSR', '0', '1');
INSERT INTO `country` VALUES ('144', 'Morocco', 'MA', 'MAR', '0', '1');
INSERT INTO `country` VALUES ('145', 'Mozambique', 'MZ', 'MOZ', '0', '1');
INSERT INTO `country` VALUES ('146', 'Myanmar', 'MM', 'MMR', '1', '1');
INSERT INTO `country` VALUES ('147', 'Namibia', 'NA', 'NAM', '0', '1');
INSERT INTO `country` VALUES ('148', 'Nauru', 'NR', 'NRU', '1', '1');
INSERT INTO `country` VALUES ('149', 'Nepal', 'NP', 'NPL', '0', '1');
INSERT INTO `country` VALUES ('150', 'Netherlands', 'NL', 'NLD', '1', '1');
INSERT INTO `country` VALUES ('151', 'Netherlands Antilles', 'AN', 'ANT', '0', '1');
INSERT INTO `country` VALUES ('152', 'New Caledonia', 'NC', 'NCL', '0', '1');
INSERT INTO `country` VALUES ('153', 'New Zealand', 'NZ', 'NZL', '1', '1');
INSERT INTO `country` VALUES ('154', 'Nicaragua', 'NI', 'NIC', '0', '1');
INSERT INTO `country` VALUES ('155', 'Niger', 'NE', 'NER', '0', '1');
INSERT INTO `country` VALUES ('156', 'Nigeria', 'NG', 'NGA', '0', '1');
INSERT INTO `country` VALUES ('157', 'Niue', 'NU', 'NIU', '1', '1');
INSERT INTO `country` VALUES ('158', 'Norfolk Island', 'NF', 'NFK', '0', '1');
INSERT INTO `country` VALUES ('159', 'Northern Mariana Islands', 'MP', 'MNP', '0', '1');
INSERT INTO `country` VALUES ('160', 'Norway', 'NO', 'NOR', '1', '1');
INSERT INTO `country` VALUES ('161', 'Oman', 'OM', 'OMN', '0', '1');
INSERT INTO `country` VALUES ('162', 'Pakistan', 'PK', 'PAK', '1', '1');
INSERT INTO `country` VALUES ('163', 'Palau', 'PW', 'PLW', '1', '1');
INSERT INTO `country` VALUES ('164', 'Panama', 'PA', 'PAN', '0', '1');
INSERT INTO `country` VALUES ('165', 'Papua New Guinea', 'PG', 'PNG', '0', '1');
INSERT INTO `country` VALUES ('166', 'Paraguay', 'PY', 'PRY', '0', '1');
INSERT INTO `country` VALUES ('167', 'Peru', 'PE', 'PER', '0', '1');
INSERT INTO `country` VALUES ('168', 'Philippines', 'PH', 'PHL', '1', '1');
INSERT INTO `country` VALUES ('169', 'Pitcairn', 'PN', 'PCN', '1', '1');
INSERT INTO `country` VALUES ('170', 'Poland', 'PL', 'POL', '1', '1');
INSERT INTO `country` VALUES ('171', 'Portugal', 'PT', 'PRT', '1', '1');
INSERT INTO `country` VALUES ('172', 'Puerto Rico', 'PR', 'PRI', '1', '1');
INSERT INTO `country` VALUES ('173', 'Qatar', 'QA', 'QAT', '0', '1');
INSERT INTO `country` VALUES ('174', 'Reunion', 'RE', 'REU', '1', '1');
INSERT INTO `country` VALUES ('175', 'Romania', 'RO', 'ROM', '1', '1');
INSERT INTO `country` VALUES ('176', 'Russian Federation', 'RU', 'RUS', '1', '1');
INSERT INTO `country` VALUES ('177', 'Rwanda', 'RW', 'RWA', '0', '1');
INSERT INTO `country` VALUES ('178', 'Saint Kitts and Nevis', 'KN', 'KNA', '1', '1');
INSERT INTO `country` VALUES ('179', 'Saint Lucia', 'LC', 'LCA', '1', '1');
INSERT INTO `country` VALUES ('180', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '1', '1');
INSERT INTO `country` VALUES ('181', 'Samoa', 'WS', 'WSM', '1', '1');
INSERT INTO `country` VALUES ('182', 'San Marino', 'SM', 'SMR', '1', '1');
INSERT INTO `country` VALUES ('183', 'Sao Tome and Principe', 'ST', 'STP', '1', '1');
INSERT INTO `country` VALUES ('184', 'Saudi Arabia', 'SA', 'SAU', '1', '1');
INSERT INTO `country` VALUES ('185', 'Senegal', 'SN', 'SEN', '0', '1');
INSERT INTO `country` VALUES ('186', 'Seychelles', 'SC', 'SYC', '0', '1');
INSERT INTO `country` VALUES ('187', 'Sierra Leone', 'SL', 'SLE', '0', '1');
INSERT INTO `country` VALUES ('188', 'Singapore', 'SG', 'SGP', '1', '1');
INSERT INTO `country` VALUES ('189', 'Slovak Republic', 'SK', 'SVK', '1', '1');
INSERT INTO `country` VALUES ('190', 'Slovenia', 'SI', 'SVN', '1', '1');
INSERT INTO `country` VALUES ('191', 'Solomon Islands', 'SB', 'SLB', '0', '1');
INSERT INTO `country` VALUES ('192', 'Somalia', 'SO', 'SOM', '1', '1');
INSERT INTO `country` VALUES ('193', 'South Africa', 'ZA', 'ZAF', '1', '1');
INSERT INTO `country` VALUES ('194', 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '1', '1');
INSERT INTO `country` VALUES ('195', 'Spain', 'ES', 'ESP', '1', '1');
INSERT INTO `country` VALUES ('196', 'Sri Lanka', 'LK', 'LKA', '1', '1');
INSERT INTO `country` VALUES ('197', 'St. Helena', 'SH', 'SHN', '1', '1');
INSERT INTO `country` VALUES ('198', 'St. Pierre and Miquelon', 'PM', 'SPM', '1', '1');
INSERT INTO `country` VALUES ('199', 'Sudan', 'SD', 'SDN', '1', '1');
INSERT INTO `country` VALUES ('200', 'Suriname', 'SR', 'SUR', '0', '1');
INSERT INTO `country` VALUES ('201', 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '1', '1');
INSERT INTO `country` VALUES ('202', 'Swaziland', 'SZ', 'SWZ', '0', '1');
INSERT INTO `country` VALUES ('203', 'Sweden', 'SE', 'SWE', '1', '1');
INSERT INTO `country` VALUES ('204', 'Switzerland', 'CH', 'CHE', '1', '1');
INSERT INTO `country` VALUES ('205', 'Syrian Arab Republic', 'SY', 'SYR', '0', '1');
INSERT INTO `country` VALUES ('206', 'Taiwan', 'TW', 'TWN', '1', '1');
INSERT INTO `country` VALUES ('207', 'Tajikistan', 'TJ', 'TJK', '1', '1');
INSERT INTO `country` VALUES ('208', 'Tanzania, United Republic of', 'TZ', 'TZA', '0', '1');
INSERT INTO `country` VALUES ('209', 'Thailand', 'TH', 'THA', '1', '1');
INSERT INTO `country` VALUES ('210', 'Togo', 'TG', 'TGO', '0', '1');
INSERT INTO `country` VALUES ('211', 'Tokelau', 'TK', 'TKL', '1', '1');
INSERT INTO `country` VALUES ('212', 'Tonga', 'TO', 'TON', '0', '1');
INSERT INTO `country` VALUES ('213', 'Trinidad and Tobago', 'TT', 'TTO', '0', '1');
INSERT INTO `country` VALUES ('214', 'Tunisia', 'TN', 'TUN', '0', '1');
INSERT INTO `country` VALUES ('215', 'Turkey', 'TR', 'TUR', '1', '1');
INSERT INTO `country` VALUES ('216', 'Turkmenistan', 'TM', 'TKM', '1', '1');
INSERT INTO `country` VALUES ('217', 'Turks and Caicos Islands', 'TC', 'TCA', '0', '1');
INSERT INTO `country` VALUES ('218', 'Tuvalu', 'TV', 'TUV', '0', '1');
INSERT INTO `country` VALUES ('219', 'Uganda', 'UG', 'UGA', '0', '1');
INSERT INTO `country` VALUES ('220', 'Ukraine', 'UA', 'UKR', '1', '1');
INSERT INTO `country` VALUES ('221', 'United Arab Emirates', 'AE', 'ARE', '0', '1');
INSERT INTO `country` VALUES ('222', 'United Kingdom', 'GB', 'GBR', '1', '1');
INSERT INTO `country` VALUES ('223', 'United States', 'US', 'USA', '1', '1');
INSERT INTO `country` VALUES ('224', 'United States Minor Outlying Islands', 'UM', 'UMI', '1', '1');
INSERT INTO `country` VALUES ('225', 'Uruguay', 'UY', 'URY', '1', '1');
INSERT INTO `country` VALUES ('226', 'Uzbekistan', 'UZ', 'UZB', '1', '1');
INSERT INTO `country` VALUES ('227', 'Vanuatu', 'VU', 'VUT', '0', '1');
INSERT INTO `country` VALUES ('228', 'Vatican City State (Holy See)', 'VA', 'VAT', '1', '1');
INSERT INTO `country` VALUES ('229', 'Venezuela', 'VE', 'VEN', '0', '1');
INSERT INTO `country` VALUES ('230', 'Viet Nam', 'VN', 'VNM', '1', '1');
INSERT INTO `country` VALUES ('231', 'Virgin Islands (British)', 'VG', 'VGB', '0', '1');
INSERT INTO `country` VALUES ('232', 'Virgin Islands (U.S.)', 'VI', 'VIR', '1', '1');
INSERT INTO `country` VALUES ('233', 'Wallis and Futuna Islands', 'WF', 'WLF', '0', '1');
INSERT INTO `country` VALUES ('234', 'Western Sahara', 'EH', 'ESH', '1', '1');
INSERT INTO `country` VALUES ('235', 'Yemen', 'YE', 'YEM', '0', '1');
INSERT INTO `country` VALUES ('236', 'Yugoslavia', 'YU', 'YUG', '1', '1');
INSERT INTO `country` VALUES ('237', 'Democratic Republic of Congo', 'CD', 'COD', '1', '1');
INSERT INTO `country` VALUES ('238', 'Zambia', 'ZM', 'ZMB', '0', '1');
INSERT INTO `country` VALUES ('239', 'Zimbabwe', 'ZW', 'ZWE', '0', '1');

-- ----------------------------
-- Table structure for `flatrole_permission`
-- ----------------------------
DROP TABLE IF EXISTS `flatrole_permission`;
CREATE TABLE `flatrole_permission` (
  `flatrole_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`flatrole_id`,`permission_id`),
  KEY `IDX_90D071A83050FE36` (`flatrole_id`),
  KEY `IDX_90D071A8FED90CCA` (`permission_id`),
  CONSTRAINT `FK_90D071A83050FE36` FOREIGN KEY (`flatrole_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_90D071A8FED90CCA` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of flatrole_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DEDCC6F5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC75E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('2', 'admin');
INSERT INTO `roles` VALUES ('1', 'guest');
INSERT INTO `roles` VALUES ('3', 'user');

-- ----------------------------
-- Table structure for `samples`
-- ----------------------------
DROP TABLE IF EXISTS `samples`;
CREATE TABLE `samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `qta` smallint(5) unsigned NOT NULL DEFAULT '0',
  `qta_expected` int(10) unsigned NOT NULL DEFAULT '0',
  `voltage` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `plug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `serigraphy` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `colors` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `cable` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `accessories` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL,
  `requested_delivery_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19925777F92F3E70` (`country_id`),
  CONSTRAINT `FK_19925777F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of samples
-- ----------------------------
INSERT INTO `samples` VALUES ('1', '', 'fsd2', '0', '0', 'Standard', 'Standard', 'Standard', 'fsd', 'fsd', 'Standard', 'Standard', '9', '0', '2014-06-19 10:32:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('2', '', 'fsd', '0', '0', 'Standard', 'Standard', 'Standard', 'fsd', 'fsd', 'Standard', 'Standard', null, '0', '2014-06-19 10:33:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('3', '', 'fsd', '0', '0', 'Standard', 'Standard', 'Standard', 'fsd', 'fsd', 'Standard', 'Standard', null, '0', '2014-06-19 10:33:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('4', '', 'fsd', '0', '0', 'Standard', 'Standard', 'Standard', 'fsd', 'fsd', 'Standard', 'Standard', null, '0', '2014-06-19 10:33:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('5', '', 'aa', '0', '0', 'Standard', 'Standard', 'Standard', 'aa', 'aa', 'Standard', 'Standard', null, '0', '2014-06-19 10:35:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('6', '', 'bb', '0', '0', 'Standard', 'Standard', 'Standard', 'bb', 'bb', 'Standard', 'Standard', null, '0', '2014-06-19 10:35:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('7', '', 'bb', '0', '0', 'Standard', 'Standard', 'Standard', 'bb', 'bb', 'Standard', 'Standard', null, '0', '2014-06-19 11:29:04', '2014-06-19 11:29:04', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('8', '', 'bb', '0', '0', 'Standard', 'Standard', 'Standard', 'bb', 'bb', 'Standard', 'Standard', null, '0', '2014-06-19 11:35:24', '2014-06-19 11:35:24', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('9', '', 'bb', '0', '0', 'Standard', 'Standard', 'Standard', 'bb', 'bb', 'Standard', 'Standard', null, '0', '2014-06-19 12:03:31', '2014-06-19 12:03:31', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('10', '', 'dd', '0', '0', 'Standard', 'Standard', 'Standard', 'das', 'das', 'Standard', 'Standard', null, '0', '2014-06-19 14:28:28', '2014-06-19 14:28:28', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('11', '', 'zz1', '0', '0', 'Standard', 'Standard', 'Standard', 'zz1', 'zz1', 'Standard', 'zz1', null, '0', '2014-06-19 14:34:40', '2014-06-19 14:34:40', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('12', '', 'bb', '0', '0', 'Standard', 'Standard', 'Standard', 'bb', 'bb', 'Standard', 'Standard', null, '0', '2014-06-19 16:43:49', '2014-06-19 16:43:49', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('13', '', 'zx', '0', '0', 'Standard', 'Standard', 'Standard', 'zx', 'zx', 'Standard', 'Standard', null, '0', '2014-06-19 16:44:22', '2014-06-19 16:44:22', '0000-00-00 00:00:00');
INSERT INTO `samples` VALUES ('14', '', 'xxx', '0', '0', 'Standard', 'Standard', 'Standard', 'xxx', 'xxx', 'Standard', 'xxx', '84', '0', '2014-06-20 14:15:32', '2014-06-20 14:15:32', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `state` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'simogrima', 'grimani@ariete.net', 'grimax', '$2y$14$oWSF7hv5Y3P396D/UcGmC.bKvzGY0YAYnZchpGm8cfsDqgWsOc9NG', '1');

-- ----------------------------
-- Table structure for `user_role`
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`),
  CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES ('1', '2');
INSERT INTO `user_role` VALUES ('1', '3');
